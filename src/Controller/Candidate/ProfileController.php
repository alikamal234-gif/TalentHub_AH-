<?php

namespace App\Controller\Candidate;

use App\Repository\CandidatureRepository;
use App\Repository\UserRepository;
use Core\Controller\AbstractController;
use Core\Http\Request;

class ProfileController extends AbstractController
{
    public function __construct(private UserRepository $userRepository,private CandidatureRepository $candidatureRepository)
    {
    }

    public function index(Request $request)
    {
        return $this->render('candidate/profile.html.twig', [
            'candidatures' => $this->candidatureRepository->findAllByUser($request->getUser())
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->getUser();

        if (!$user) {
            $request->session()->setFlash('error', 'Utilisateur non trouvé.');
            $this->redirectToPath('/auth');
            return;
        }

        $name = $request->post('name');
        $email = $request->post('email');
        $phone = $request->post('phone');
        $speciality = $request->post('speciality');

        $user->setName($name)
            ->setEmail($email)
            ->setPhone($phone)
            ->setSpeciality($speciality);

        // Handle image upload if exists
        $image = $request->file('image');
        if ($image && $image['size'] > 0) {
            $imageData = file_get_contents($image['tmp_name']);
            $user->setImage($imageData);
        }

        $this->userRepository->update($user);

        // Update user in session
        $request->session()->set('auth_user', $user);

        $request->session()->setFlash('success', 'Profil mis à jour avec succès.');

        $this->redirectToPath('/candidate/profile');
    }

    public function changePassword(Request $request)
    {
        $user = $request->getUser();

        if (!$user) {
            $this->redirectToPath('/auth');
            return;
        }

        $currentPassword = $request->post('current_password');
        $newPassword = $request->post('new_password');
        $confirmPassword = $request->post('confirm_password');

        if (!password_verify($currentPassword, $user->getPassword())) {
            $request->session()->setFlash('error', 'Le mot de passe actuel est incorrect.');
            $this->redirectToPath('/candidate/profile');
            return;
        }

        if ($newPassword !== $confirmPassword) {
            $request->session()->setFlash('error', 'Les nouveaux mots de passe ne correspondent pas.');
            $this->redirectToPath('/candidate/profile');
            return;
        }

        if (strlen($newPassword) < 6) {
            $request->session()->setFlash('error', 'Le nouveau mot de passe doit contenir au moins 6 caractères.');
            $this->redirectToPath('/candidate/profile');
            return;
        }

        $user->setPassword(password_hash($newPassword, PASSWORD_DEFAULT));
        $this->userRepository->update($user);

        $request->session()->setFlash('success', 'Mot de passe modifié avec succès.');
        $this->redirectToPath('/candidate/profile');
    }
}