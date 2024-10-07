<?php

namespace Inventory\Models;

class Supplier
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllSuppliers()
    {
        $stmt = $this->db->query("SELECT * FROM suppliers ORDER BY name");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getSupplierById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM suppliers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createSupplier($data)
    {
        $stmt = $this->db->prepare("INSERT INTO suppliers (name, contact_person, email, phone, address) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'],
            $data['contact_person'],
            $data['email'],
            $data['phone'],
            $data['address']
        ]);
    }

    public function updateSupplier($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE suppliers SET name = ?, contact_person = ?, email = ?, phone = ?, address = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'],
            $data['contact_person'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $id
        ]);
    }

    public function deleteSupplier($id)
    {
        $stmt = $this->db->prepare("DELETE FROM suppliers WHERE id = ?");
        return $stmt->execute([$id]);
    }
}