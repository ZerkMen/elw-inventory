<?php

namespace Inventory\Helpers;

use Inventory\Models\User;

class Auth
{
    public static function login($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
    }

    public static function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        session_destroy();
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public static function requireLogin()
    {
        if (!self::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
    }

    public static function user()
    {
        if (self::isLoggedIn()) {
            $userModel = new User(Database::getInstance()->getConnection());
            return $userModel->getUserById($_SESSION['user_id']);
        }
        return null;
    }

    public static function getUser()
    {
        if (self::isLoggedIn()) {
            $userModel = new \Inventory\Models\User(Database::getInstance()->getConnection());
            $user = $userModel->getUserById($_SESSION['user_id']);
            // Stellen Sie sicher, dass die Rolle im Benutzer-Array enthalten ist
            if ($user && !isset($user['role'])) {
                error_log("User found but role is missing: " . json_encode($user));
            }
            return $user;
        }
        return null;
    }
    
    public static function id()
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function username()
    {
        return $_SESSION['username'] ?? null;
    }

    public static function check()
    {
        return self::isLoggedIn();
    }
}