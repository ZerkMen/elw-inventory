<?php

namespace Inventory\Controllers;

use Inventory\Models\Discount;
use Inventory\Models\Product;
use Inventory\Models\Customer;

class DiscountController extends BaseController
{
    private $discountModel;
    private $productModel;
    private $customerModel;

    public function __construct()
    {
        parent::__construct();
        $this->discountModel = new Discount($this->db);
        $this->productModel = new Product($this->db);
        $this->customerModel = new Customer($this->db);
    }

    public function index()
    {
        $this->requirePermission('viewDiscounts');

        $discounts = $this->discountModel->getAllDiscounts();
        $this->render('discounts/index', ['discounts' => $discounts]);
    }

    public function create()
    {
        $this->requirePermission('manageDiscounts');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'type' => $_POST['type'],
                'value' => $_POST['value'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'product_id' => !empty($_POST['product_id']) ? $_POST['product_id'] : null,
                'customer_id' => !empty($_POST['customer_id']) ? $_POST['customer_id'] : null
            ];

            if ($this->discountModel->createDiscount($data)) {
                $this->setFlashMessage('success', 'Rabatt erfolgreich erstellt.');
                $this->redirect('/discounts');
            } else {
                $this->setFlashMessage('error', 'Fehler beim Erstellen des Rabatts.');
            }
        }

        $products = $this->productModel->getAllProducts();
        $customers = $this->customerModel->getAllCustomers();
        $this->render('discounts/create', ['products' => $products, 'customers' => $customers]);
    }

    public function edit($id)
    {
        $this->requirePermission('manageDiscounts');
    
        $discount = $this->discountModel->getDiscountById($id);
        if (!$discount) {
            $this->setFlashMessage('error', 'Rabatt nicht gefunden.');
            $this->redirect('/discounts');
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'type' => $_POST['type'],
                'value' => $_POST['value'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'product_id' => !empty($_POST['product_id']) ? $_POST['product_id'] : null,
                'customer_id' => !empty($_POST['customer_id']) ? $_POST['customer_id'] : null
            ];
    
            if ($this->discountModel->updateDiscount($id, $data)) {
                $this->setFlashMessage('success', 'Rabatt erfolgreich aktualisiert.');
                $this->redirect('/discounts');
            } else {
                $this->setFlashMessage('error', 'Fehler beim Aktualisieren des Rabatts.');
            }
        }
    
        $products = $this->productModel->getAllProducts();
        $customers = $this->customerModel->getAllCustomers();
        $this->render('discounts/edit', [
            'discount' => $discount,
            'products' => $products,
            'customers' => $customers
        ]);
    }

    public function delete($id)
    {
        $this->requirePermission('manageDiscounts');

        if ($this->discountModel->deleteDiscount($id)) {
            $this->setFlashMessage('success', 'Rabatt erfolgreich gelöscht.');
        } else {
            $this->setFlashMessage('error', 'Fehler beim Löschen des Rabatts.');
        }

        $this->redirect('/discounts');
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

