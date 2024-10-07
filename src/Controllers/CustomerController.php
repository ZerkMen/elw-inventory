<?php

namespace Inventory\Controllers;

use Inventory\Models\Customer;

class CustomerController extends BaseController
{
    private $customerModel;

    public function __construct()
    {
        parent::__construct();
        $this->customerModel = new Customer($this->db);
    }

    public function index()
    {
        $customers = $this->customerModel->getAllCustomers();
        $this->render('customers/index', ['title' => 'Customers', 'customers' => $customers]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address']
            ];
            if ($this->customerModel->createCustomer($data)) {
                $this->setFlashMessage('success', 'Customer created successfully.');
                $this->redirect('/customers');
            } else {
                $this->setFlashMessage('error', 'Failed to create customer.');
            }
        }
        $this->render('customers/create', ['title' => 'Create Customer']);
    }

    public function edit($id)
    {
        $customer = $this->customerModel->getCustomerById($id);
        if (!$customer) {
            $this->setFlashMessage('error', 'Customer not found.');
            $this->redirect('/customers');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address']
            ];
            if ($this->customerModel->updateCustomer($id, $data)) {
                $this->setFlashMessage('success', 'Customer updated successfully.');
                $this->redirect('/customers');
            } else {
                $this->setFlashMessage('error', 'Failed to update customer.');
            }
        }
        $this->render('customers/edit', ['title' => 'Edit Customer', 'customer' => $customer]);
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->customerModel->deleteCustomer($id)) {
                $this->setFlashMessage('success', 'Customer deleted successfully.');
            } else {
                $this->setFlashMessage('error', 'Failed to delete customer.');
            }
            $this->redirect('/customers');
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
