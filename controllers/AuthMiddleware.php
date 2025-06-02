<?php

class AuthMiddleware
{
    private $authController;

    public function __construct()
    {
        $this->authController = new AuthController('', []);
    }

    public function requireAuth(): bool
    {
        $user = $this->authController->getCurrentUser();

        if (!$user) {
            jumpTo('/auth/login');
            return false;
        }

        return true;
    }

    public function getAuthenticatedUser(): ?array
    {
        return $this->authController->getCurrentUser();
    }
}
