<?php

namespace Inventory\Controllers;

use Inventory\Models\User;
use Inventory\Helpers\Auth;
use Inventory\Helpers\ImageUploader;

class ProfileController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User($this->db);
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            $this->notFound();
        }
        $this->render('profile/index', ['title' => 'My Profile', 'user' => $user]);
    }

    public function edit()
    {
        $user = Auth::user();

        if (!$user) {
            $this->notFound();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email']
            ];

            if (!empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }

            if ($_FILES['avatar']['size'] > 0) {
                try {
                    $data['avatar_path'] = ImageUploader::upload($_FILES['avatar'], 'avatars');
                } catch (\Exception $e) {
                    $this->setFlashMessage('error', 'Avatar upload failed: ' . $e->getMessage());
                    $this->redirect('/profile/edit');
                }
            }

            if ($this->userModel->updateUser($user['id'], $data)) {
                $this->setFlashMessage('success', 'Profile updated successfully.');
                $this->redirect('/profile');
            } else {
                $this->setFlashMessage('error', 'Failed to update profile.');
            }
        }

        $this->render('profile/edit', ['title' => 'Edit Profile', 'user' => $user]);
    }

    private function setFlashMessage($type, $message)
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    private function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    private function notFound()
    {
        http_response_code(404);
        $this->render('errors/404', ['title' => 'Not Found']);
        exit;
    }
}
