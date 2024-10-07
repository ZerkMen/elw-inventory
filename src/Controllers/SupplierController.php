<?php

namespace Inventory\Controllers;

use Inventory\Models\Supplier;

class SupplierController extends BaseController
{
    private $supplierModel;

    public function __construct()
    {
        parent::__construct();
        $this->supplierModel = new Supplier($this->db);
    }

    public function index()
    {
        $this->requirePermission('viewSuppliers');
        $suppliers = $this->supplierModel->getAllSuppliers();
        $this->render('suppliers/index', ['suppliers' => $suppliers]);
    }

    public function create()
    {
        $this->requirePermission('manageSuppliers');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'contact_person' => $_POST['contact_person'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address']
            ];

            if ($this->supplierModel->createSupplier($data)) {
                $this->setFlashMessage('success', 'Lieferant erfolgreich erstellt.');
                $this->redirect('/suppliers');
            } else {
                $this->setFlashMessage('error', 'Fehler beim Erstellen des Lieferanten.');
            }
        }

        $this->render('suppliers/create');
    }

    public function edit($id)
    {
        $this->requirePermission('manageSuppliers');

        $supplier = $this->supplierModel->getSupplierById($id);
        if (!$supplier) {
            $this->setFlashMessage('error', 'Lieferant nicht gefunden.');
            $this->redirect('/suppliers');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'contact_person' => $_POST['contact_person'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address']
            ];

            if ($this->supplierModel->updateSupplier($id, $data)) {
                $this->setFlashMessage('success', 'Lieferant erfolgreich aktualisiert.');
                $this->redirect('/suppliers');
            } else {
                $this->setFlashMessage('error', 'Fehler beim Aktualisieren des Lieferanten.');
            }
        }

        $this->render('suppliers/edit', ['supplier' => $supplier]);
    }

    public function delete($id)
    {
        $this->requirePermission('manageSuppliers');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->supplierModel->deleteSupplier($id)) {
                $this->setFlashMessage('success', 'Lieferant erfolgreich gelöscht.');
            } else {
                $this->setFlashMessage('error', 'Fehler beim Löschen des Lieferanten.');
            }
            $this->redirect('/suppliers');
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
        exit();
    }
}
