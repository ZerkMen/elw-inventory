<?php

namespace Inventory\Models;

class Product
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllProducts()
    {
        $stmt = $this->db->query("
            SELECT p.*, c.name as category_name, s.name as supplier_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN suppliers s ON p.supplier_id = s.id 
            ORDER BY p.name
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name, s.name as supplier_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN suppliers s ON p.supplier_id = s.id 
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createProduct($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO products (name, description, price, quantity, category_id, supplier_id, min_stock_level, image_path, article_number) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['quantity'],
            $data['category_id'],
            $data['supplier_id'],
            $data['min_stock_level'],
            $data['image_path'],
            $data['article_number']
        ]);
    }

    public function updateProduct($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE products 
            SET name = ?, description = ?, price = ?, quantity = ?, category_id = ?, 
                supplier_id = ?, min_stock_level = ?, image_path = ?, article_number = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['quantity'],
            $data['category_id'],
            $data['supplier_id'],
            $data['min_stock_level'],
            $data['image_path'],
            $data['article_number'],
            $id
        ]);
    }

    public function deleteProduct($id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getLowStockProducts()
    {
        $stmt = $this->db->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.quantity <= p.min_stock_level ORDER BY p.quantity ASC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateMinStockLevel($id, $minStockLevel)
    {
        $stmt = $this->db->prepare("UPDATE products SET min_stock_level = ? WHERE id = ?");
        return $stmt->execute([$minStockLevel, $id]);
    }

    public function getTotalProducts()
    {
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM products");
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
