<?php

namespace app\classes;

use app\database\models\User;

class Login
{
    public function login($email, $password)
    {
        $user = new User;
        $userFound = $user->findBy('email', $email);

        if (!$userFound) {
            return false;
        }

        if (password_verify($password, $userFound->password)) {
            $_SESSION['user'] = [
                'firstName' => $userFound->firstName,
                'lastName' => $userFound->lastName,
                'email' => $userFound->email,
            ];

            return true;
        }

        return false;
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
    }
}
