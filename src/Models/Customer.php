<?php

namespace Inventory\Models;

class Customer
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllCustomers()
    {
        $stmt = $this->db->query("SELECT * FROM customers ORDER BY name");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCustomerById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM customers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createCustomer($data)
    {
        $stmt = $this->db->prepare("INSERT INTO customers (name, email, phone, address) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['name'], $data['email'], $data['phone'], $data['address']]);
    }

    public function updateCustomer($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE customers SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['email'], $data['phone'], $data['address'], $id]);
    }

    public function deleteCustomer($id)
    {
        $stmt = $this->db->prepare("DELETE FROM customers WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getTotalCustomers()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM customers");
        return $stmt->fetchColumn();
    }
}
