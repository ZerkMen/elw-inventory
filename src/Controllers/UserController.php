<?php

namespace Inventory\Controllers;

use Inventory\Models\User;
use Inventory\Helpers\ImageUploader;

class UserController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User($this->db);
    }

    public function index()
    {
        $users = $this->userModel->getAllUsers();
        $this->render('users/index', ['title' => 'Users', 'users' => $users]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            // Avatar hochladen, falls vorhanden
            if ($_FILES['avatar']['size'] > 0) {
                try {
                    $data['avatar_path'] = ImageUploader::upload($_FILES['avatar']);
                } catch (\Exception $e) {
                    $this->setFlashMessage('error', 'Avatar upload failed: ' . $e->getMessage());
                    $this->redirect('/users/create');
                }
            } else {
                $data['avatar_path'] = null;
            }

            if ($this->userModel->createUser($data)) {
                $this->setFlashMessage('success', 'User created successfully.');
                $this->redirect('/users');
            } else {
                $this->setFlashMessage('error', 'Failed to create user.');
                $this->redirect('/users/create');
            }
        }

        $this->render('users/create', ['title' => 'Create User']);
    }

    public function edit($id)
    {
        $user = $this->userModel->getUserById($id);

        if (!$user) {
            $this->notFound();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            // Avatar hochladen, falls vorhanden
            if ($_FILES['avatar']['size'] > 0) {
                try {
                    $data['avatar_path'] = ImageUploader::upload($_FILES['avatar']);
                } catch (\Exception $e) {
                    $this->setFlashMessage('error', 'Avatar upload failed: ' . $e->getMessage());
                    $this->redirect("/users/edit/$id");
                }
            }

            if ($this->userModel->updateUser($id, $data)) {
                $this->setFlashMessage('success', 'User updated successfully.');
                $this->redirect('/users');
            } else {
                $this->setFlashMessage('error', 'Failed to update user.');
                $this->redirect("/users/edit/$id");
            }
        }

        $this->render('users/edit', ['title' => 'Edit User', 'user' => $user]);
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->userModel->deleteUser($id)) {
                $this->setFlashMessage('success', 'User deleted successfully.');
            } else {
                $this->setFlashMessage('error', 'Failed to delete user.');
            }
            $this->redirect('/users');
        } else {
            $this->notFound();
        }
    }

    // Methode zum Setzen von Flash-Nachrichten
    private function setFlashMessage($type, $message)
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    // Methode zur Umleitung
    private function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    // Methode zur Anzeige der 404-Seite
    private function notFound()
    {
        http_response_code(404);
        $this->render('errors/404', ['title' => 'Not Found']);
        exit;
    }
}
