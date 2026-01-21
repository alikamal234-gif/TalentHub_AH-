<?php

namespace App\Controller\Auth;

use App\Service\AuthService;
use Core\Controller\AbstractController;
use Core\Http\Request;
use Core\Http\Response;

class AuthentificationController extends AbstractController
{
    public function __construct(private AuthService $authService)
    {
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
        $user = $request->getUser();

        if ($user?->getRole()->isAdmin()) {
            $this->redirectToPath("/admin");
        } else if ($user?->getRole()->isRecruiter()) {
            $this->redirectToPath("/recruiter");
        }
        $this->redirectToPath("/candidate");
    }

    public function register(Request $request)
    {

    }

    public function logout()
    {
        if ($this->authService->isAuthenticated()) {
            $this->authService->logout();
        }
        $this->redirectToPath("/");
    }
}