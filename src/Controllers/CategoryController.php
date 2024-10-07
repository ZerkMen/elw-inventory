<?php

namespace Inventory\Controllers;

use Inventory\Models\Category;

class CategoryController extends BaseController
{
    private $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new Category($this->db);
    }

    public function index()
    {
        $categories = $this->categoryModel->getAllCategories();
        $this->render('categories/index', ['title' => 'Categories', 'categories' => $categories]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->categoryModel->createCategory($_POST);
            $this->setFlashMessage('success', 'Kategorie erfolgreich erstellt.');
            $this->redirect('/categories');
        }
        $this->render('categories/create', ['title' => 'Create Category']);
    }

    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);

        if (!$category) {
            $this->notFound();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->categoryModel->updateCategory($id, $_POST);
            $this->setFlashMessage('success', 'Kategorie erfolgreich aktualisiert.');
            $this->redirect('/categories');
        }

        $this->render('categories/edit', ['title' => 'Edit Category', 'category' => $category]);
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->categoryModel->deleteCategory($id);
            $this->setFlashMessage('success', 'Kategorie erfolgreich gelöscht.');
            $this->redirect('/categories');
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
