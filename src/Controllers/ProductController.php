<?php

namespace Inventory\Controllers;

use Inventory\Models\Product;
use Inventory\Models\Category;
use Inventory\Models\Supplier;
use Inventory\Helpers\ImageUploader;

class ProductController extends BaseController
{
    private $productModel;
    private $categoryModel;
    private $supplierModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product($this->db);
        $this->categoryModel = new Category($this->db);
        $this->supplierModel = new Supplier($this->db);
    }

    public function index()
    {
        $products = $this->productModel->getAllProducts();
        $this->render('products/index', ['title' => 'Products', 'products' => $products]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleCreateOrUpdate();
        } else {
            $categories = $this->categoryModel->getAllCategories();
            $suppliers = $this->supplierModel->getAllSuppliers();
            $this->render('products/create', [
                'title' => 'Create Product',
                'categories' => $categories,
                'suppliers' => $suppliers
            ]);
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            $this->notFound();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleCreateOrUpdate($id);
        } else {
            $categories = $this->categoryModel->getAllCategories();
            $suppliers = $this->supplierModel->getAllSuppliers();
            $this->render('products/edit', [
                'title' => 'Edit Product',
                'product' => $product,
                'categories' => $categories,
                'suppliers' => $suppliers
            ]);
        }
    }

    public function delete($id)
    {
        $this->requirePermission('products');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->productModel->deleteProduct($id)) {
                $this->setFlashMessage('success', 'Product deleted successfully.');
            } else {
                $this->setFlashMessage('error', 'Failed to delete product.');
            }
            $this->redirect('/products');
        } else {
            $product = $this->productModel->getProductById($id);
            if (!$product) {
                $this->notFound();
            }
            $this->render('products/delete', ['title' => 'Delete Product', 'product' => $product]);
        }
    }

    private function handleCreateOrUpdate($id = null)
    {
        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'quantity' => $_POST['quantity'],
            'category_id' => $_POST['category_id'],
            'supplier_id' => $_POST['supplier_id'],
            'min_stock_level' => $_POST['min_stock_level'],
            'article_number' => $_POST['article_number']
        ];

        // Eingabedaten validieren
        if (empty($data['name']) || empty($data['price']) || empty($data['quantity'])) {
            $this->setFlashMessage('error', 'Please fill in all required fields.');
            $this->redirect($id ? "/products/edit/$id" : '/products/create');
        }

        // Bild hochladen (falls vorhanden)
        if ($_FILES['image']['size'] > 0) {
            try {
                $data['image_path'] = ImageUploader::upload($_FILES['image']);
            } catch (\Exception $e) {
                $this->setFlashMessage('error', 'Image upload failed: ' . $e->getMessage());
                $this->redirect($id ? "/products/edit/$id" : '/products/create');
            }
        } elseif ($id) {
            $product = $this->productModel->getProductById($id);
            $data['image_path'] = $product['image_path']; // Behalte das bestehende Bild
        }

        // Speichern oder Aktualisieren des Produkts
        if ($id) {
            $success = $this->productModel->updateProduct($id, $data);
            $message = 'Product updated successfully.';
        } else {
            $success = $this->productModel->createProduct($data);
            $message = 'Product created successfully.';
        }

        if ($success) {
            $this->setFlashMessage('success', $message);
            $this->redirect('/products');
        } else {
            $this->setFlashMessage('error', 'Failed to save product.');
            $this->redirect($id ? "/products/edit/$id" : '/products/create');
        }
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
