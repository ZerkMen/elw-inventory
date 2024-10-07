<?php
namespace Inventory\Controllers;

use Inventory\Models\Inventory;
use Inventory\Models\Category;
use Inventory\Models\Supplier;

class InventoryController extends BaseController
{
    private $inventoryModel;
    private $categoryModel;
    private $supplierModel;

    public function __construct()
    {
        parent::__construct();
        $this->inventoryModel = new Inventory($this->db);
        $this->categoryModel = new Category($this->db);
        $this->supplierModel = new Supplier($this->db);
    }

    // Anzeige des Inventarübersichts
    public function index()
    {
        $inventory = $this->inventoryModel->getAllInventory();
        $this->render('inventory/index', ['title' => 'Inventar', 'inventory' => $inventory]);
    }

    // Erstellen eines neuen Inventargegenstands (Produkts)
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleCreateOrUpdate();
        } else {
            $categories = $this->categoryModel->getAllCategories();
            $suppliers = $this->supplierModel->getAllSuppliers();
            $this->render('inventory/create', [
                'title' => 'Neues Inventar anlegen',
                'categories' => $categories,
                'suppliers' => $suppliers
            ]);
        }
    }

    public function edit($id)
    {
        $inventory = $this->inventoryModel->getInventoryById($id);

        if (!$inventory) {
            $this->notFound();
        }

        // Prüfen, ob es eine POST-Anfrage ist (wird vom Formular gesendet)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Erfassung der POST-Daten
            $data = [
                'name' => $_POST['name'],
                'quantity' => $_POST['quantity'],
                'supplier_id' => $_POST['supplier_id'],
                'category_id' => $_POST['category_id'],
                'min_stock_level' => $_POST['min_stock_level']
            ];

            // Aufruf der Methode zum Aktualisieren des Datensatzes
            if ($this->inventoryModel->updateInventory($id, $data)) {
                // Flash-Nachricht setzen und umleiten
                $this->setFlashMessage('success', 'Inventar erfolgreich aktualisiert.');
                $this->redirect('/inventory');
            } else {
                $this->setFlashMessage('error', 'Es gab ein Problem beim Aktualisieren des Datensatzes.');
            }
        }

        $categories = $this->categoryModel->getAllCategories();
        $suppliers = $this->supplierModel->getAllSuppliers();

        $this->render('inventory/edit', [
            'inventory' => $inventory,
            'categories' => $categories,
            'suppliers' => $suppliers
        ]);
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
        exit();
    }

    // Methode zur Anzeige der 404-Seite
    private function notFound()
    {
        http_response_code(404);
        $this->render('errors/404', ['title' => 'Not Found']);
        exit();
    }
}
