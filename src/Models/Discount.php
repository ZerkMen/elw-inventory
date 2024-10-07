<?php

namespace Inventory\Models;

class Discount
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllDiscounts()
    {
        try {
            $stmt = $this->db->query("SELECT d.*, p.name as product_name, c.name as customer_name 
                                    FROM discounts d 
                                    LEFT JOIN products p ON d.product_id = p.id 
                                    LEFT JOIN customers c ON d.customer_id = c.id 
                                    ORDER BY d.start_date DESC");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Log the error
            error_log("Database error: " . $e->getMessage());
            // You might want to throw a custom exception here
            throw new \Exception("Ein Fehler ist bei der Datenbankabfrage aufgetreten.");
        }
    }

    public function getDiscountById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM discounts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createDiscount($data)
    {
        $sql = "INSERT INTO discounts (name, type, value, start_date, end_date, product_id, customer_id) 
                VALUES (:name, :type, :value, :start_date, :end_date, :product_id, :customer_id)";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':name' => $data['name'],
            ':type' => $data['type'],
            ':value' => $data['value'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':product_id' => !empty($data['product_id']) ? $data['product_id'] : null,
            ':customer_id' => !empty($data['customer_id']) ? $data['customer_id'] : null
        ]);
    }

    public function updateDiscount($id, $data)
    {
        $sql = "UPDATE discounts 
                SET name = :name, type = :type, value = :value, 
                    start_date = :start_date, end_date = :end_date, 
                    product_id = :product_id, customer_id = :customer_id 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':type' => $data['type'],
            ':value' => $data['value'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':product_id' => !empty($data['product_id']) ? $data['product_id'] : null,
            ':customer_id' => !empty($data['customer_id']) ? $data['customer_id'] : null
        ]);
    }

    public function deleteDiscount($id)
    {
        $stmt = $this->db->prepare("DELETE FROM discounts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getActiveDiscounts()
    {
        $currentDate = date('Y-m-d');
        $stmt = $this->db->prepare("SELECT * FROM discounts WHERE start_date <= ? AND end_date >= ?");
        $stmt->execute([$currentDate, $currentDate]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
