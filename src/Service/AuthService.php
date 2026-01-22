<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Core\Http\Request;
use Core\Http\Session;

class AuthService
{
    private UserRepository $userRepository;
    private Session $session;

    public function __construct(UserRepository $userRepository, Request $request)
    {
        $this->userRepository = $userRepository;
        $this->session = $request->session();
    }

    /**
     * Authenticate a user by their email and store them in the session.
     *
     * @param string $email
     * @param string $password
     * @return bool True if the user was found and logged in, false otherwise.
     */
    public function login(string $email, string $password): bool
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user && password_verify($password, $user->getPassword())) {
            $this->session->set('auth_user', $user);
            return true;
        }

        return false;
    }

    /**
     * Log out the current user by removing them from the session.
     */
    public function logout(): void
    {
        $this->session->remove('auth_user');
    }

    /**
     * Check if a user is currently authenticated.
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return $this->session->has('auth_user');
    }
}
