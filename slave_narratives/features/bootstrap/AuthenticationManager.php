<?php

namespace Features\Bootstrap;

class AuthenticationManager
{
    private bool $loggedIn = false;
    private string $username;
    private string $password;
    private string $error;
    private string $confirmMsg;

    public function login($_username, $_password): bool
    {
        if ($_username == "recits-esclaves@univ-tlse2.fr" && $_password == "admin")
        {
            $this->loggedIn=true;
            return $this->loggedIn;
        }

        $this->error = sprintf('Login failed for username: %s and password: %s', $_username, $_password);
        return $this->loggedIn;
    }

    public function verifyUsername(): bool
    {
        return $this->username == "recits-esclaves@univ-tlse2.fr";
    }

    public function verifyPassword(): bool
    {
        return $this->password==="admin";
    }

    public function setUsername($_username): void
    {
        $this->username = $_username;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setPassword($_password): void
    {
        $this->password = $_password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getLoginError(): string
    {
        return $this->error;
    }

    public function logout(): void
    {
        $this->loggedIn = false;
    }

    public function isLoggedIn(): bool
    {
        return $this->loggedIn;
    }

    public function passwordResetConfirmationMessage(): string
    {
        if ($this->verifyUsername())
        {
            $content = "Message de confirmation pour la réinitialisation du mot de passe";
        } else {
            $content = "Utilisateur incorrect pour la réinitialisation du mot passe";
        }

        $this->confirmMsg = $content;
        return $content;
    }

    public function getConfirmationMessage(): string
    {
        return $this->confirmMsg;
    }
}