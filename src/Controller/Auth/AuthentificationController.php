<?php

namespace App\Controller\Auth;

use App\Entity\User;
use App\Service\AuthService;
use Core\Controller\AbstractController;
use Core\Http\Request;
use Core\Http\Response;

class AuthentificationController extends AbstractController
{
    public function __construct(
        private AuthService $authService,
        private \App\Repository\UserRepository $userRepository,
        private \App\Repository\RoleRepository $roleRepository
    ) {
    }

    public function index(): Response
    {
        return $this->render("auth/index.html.twig");
    }

    public function login(Request $request)
    {
        $email = $request->post("email");
        $password = $request->post("password");
        $this->authService->login($email, $password);
        $this->userRedirect($request->getUser());
    }

    public function register(Request $request)
    {
        $roleName = $request->post('role') === 'recruiter' ? 'Recruiter' : 'Candidate';
        $role = $this->roleRepository->findByName($roleName);

        if (!$role) {
            $this->redirectToPath("/auth");
            return;
        }

        $imageBinary = null;
        $profileImage = $request->file('profileImage');
        if ($profileImage && !empty($profileImage['tmp_name'])) {
            $imageBinary = file_get_contents($profileImage['tmp_name']);
        }

        $user = new User(
            $role,
            $request->post('firstName'),
            $request->post('email'),
            $request->post('password')
        );

        $user->setPhone($request->post('phone'))
            ->setSpeciality($request->post('speciality'))
            ->setImage($imageBinary);

        $this->userRepository->create($user);

        // Auto-login after registration
        $this->authService->login($user->getEmail(), $request->post('password'));

        $this->userRedirect($user);
    }

    public function userRedirect(?User $user): void
    {
        if ($user?->getRole()->isAdmin()) {
            $this->redirectToPath("/admin");
        } else if ($user?->getRole()->isRecruiter()) {
            $this->redirectToPath("/recruteur");
        }
        $this->redirectToPath("/candidate");
    }

    public function logout()
    {
        if ($this->authService->isAuthenticated()) {
            $this->authService->logout();
        }
        $this->redirectToPath("/");
    }
}