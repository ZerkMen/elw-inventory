<?php

namespace Inventory\Controllers;

use Inventory\Models\Order;
use Inventory\Models\Customer;
use Inventory\Models\Product;

class OrderController extends BaseController
{
    private $orderModel;
    private $customerModel;
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new Order($this->db);
        $this->customerModel = new Customer($this->db);
        $this->productModel = new Product($this->db);
    }

    public function index()
    {
        $orders = $this->orderModel->getAllOrders();
        $this->render('orders/index', ['title' => 'Orders', 'orders' => $orders]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'customer_id' => $_POST['customer_id'],
                'total_amount' => $_POST['total_amount'],
                'status' => 'Ausstehend',
                'items' => json_decode($_POST['items'], true)
            ];
            try {
                $orderId = $this->orderModel->createOrder($data);
                $this->setFlashMessage('success', 'Order created successfully.');
                $this->redirect('/orders/view/' . $orderId);
            } catch (\Exception $e) {
                $this->setFlashMessage('error', 'Failed to create order: ' . $e->getMessage());
            }
        }
        $customers = $this->customerModel->getAllCustomers();
        $products = $this->productModel->getAllProducts();
        $this->render('orders/create', ['title' => 'Create Order', 'customers' => $customers, 'products' => $products]);
    }

    public function view($id)
    {
        $order = $this->orderModel->getOrderById($id);
        if (!$order) {
            $this->setFlashMessage('error', 'Order not found.');
            $this->redirect('/orders');
        }
        $orderItems = $this->orderModel->getOrderItems($id);
        $this->render('orders/view', ['title' => 'View Order', 'order' => $order, 'orderItems' => $orderItems]);
    }

    public function updateStatus($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'];
            if ($this->orderModel->updateOrderStatus($id, $status)) {
                $this->setFlashMessage('success', 'Order status updated successfully.');
            } else {
                $this->setFlashMessage('error', 'Failed to update order status.');
            }
            $this->redirect('/orders/view/' . $id);
        }
    }

    // Neue Methode zum Löschen einer Bestellung
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Validierung der Bestell-ID
            if (!ctype_digit($id)) {
                $this->setFlashMessage('error', 'Invalid order ID.');
                $this->redirect('/orders');
            }

            try {
                if ($this->orderModel->deleteOrder($id)) {
                    $this->setFlashMessage('success', 'Order deleted successfully.');
                } else {
                    $this->setFlashMessage('error', 'Failed to delete order.');
                }
            } catch (\Exception $e) {
                $this->setFlashMessage('error', 'Error deleting order: ' . $e->getMessage());
            }
            $this->redirect('/orders');
        } else {
            // Bei GET-Anfragen Weiterleitung oder Fehlermeldung
            $this->setFlashMessage('error', 'Invalid request method.');
            $this->redirect('/orders');
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
