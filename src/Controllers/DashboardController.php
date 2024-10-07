<?php

namespace Inventory\Controllers;

use Inventory\Models\Product;
use Inventory\Models\Order;
use Inventory\Models\Customer;

class DashboardController extends BaseController
{
    public function index()
    {
        $this->requirePermission('viewDashboard');

        $productModel = new Product($this->db);
        $orderModel = new Order($this->db);
        $customerModel = new Customer($this->db);

        $totalProducts = $productModel->getTotalProducts();
        $lowStockProducts = count($productModel->getLowStockProducts());
        $totalOrders = $orderModel->getTotalOrders();
        $recentOrders = $orderModel->getRecentOrders(5);
        $totalCustomers = $customerModel->getTotalCustomers();
        $totalRevenue = $orderModel->getTotalRevenue();

        $this->render('dashboard/index', compact('totalProducts', 'lowStockProducts', 'totalOrders', 'recentOrders', 'totalCustomers', 'totalRevenue'));
    }
}