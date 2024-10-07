<?php

namespace Inventory\Controllers;

use Inventory\Models\User;
use Inventory\Helpers\Auth;

class AuthController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User($this->db);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                Auth::login($user);
                header('Location: /');
                exit;
            } else {
                $error = "Invalid username or password";
            }
        }

        $this->render('auth/login', ['title' => 'Login', 'error' => $error ?? null]);
    }

    public function logout()
    {
        Auth::logout();
        header('Location: /login');
        exit;
    }
}