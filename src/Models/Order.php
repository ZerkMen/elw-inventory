<?php
namespace Inventory\Models;

class Order
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllOrders()
    {
        $sql = "SELECT o.*, c.name as customer_name
                FROM orders o
                JOIN customers c ON o.customer_id = c.id
                ORDER BY o.order_date DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOrderById($id)
    {
        $sql = "SELECT o.*, c.name as customer_name
                FROM orders o
                JOIN customers c ON o.customer_id = c.id
                WHERE o.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createOrder($data)
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("INSERT INTO orders (customer_id, total_amount, status) VALUES (?, ?, ?)");
            $stmt->execute([$data['customer_id'], $data['total_amount'], $data['status']]);
            $orderId = $this->db->lastInsertId();
            foreach ($data['items'] as $item) {
                $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                $stmt->execute([$orderId, $item['product_id'], $item['quantity'], $item['price']]);
                // Update product quantity
                $stmt = $this->db->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
                $stmt->execute([$item['quantity'], $item['product_id']]);
            }
            $this->db->commit();
            return $orderId;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function updateOrderStatus($id, $status)
    {
        $stmt = $this->db->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function getOrderItems($orderId)
    {
        $sql = "SELECT oi.*, p.name as product_name
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTotalOrders()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM orders");
        return $stmt->fetchColumn();
    }

    public function getRecentOrders($limit = 5)
    {
        $stmt = $this->db->prepare("
            SELECT o.id, o.total_amount, o.status, c.name as customer_name
            FROM orders o
            JOIN customers c ON o.customer_id = c.id
            ORDER BY o.order_date DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTotalRevenue()
    {
        $stmt = $this->db->query("SELECT SUM(total_amount) FROM orders");
        return $stmt->fetchColumn();
    }

    public function deleteOrder($id)
    {
        $this->db->beginTransaction();
        try {
            // Löschen der Bestellpositionen (falls vorhanden)
            $stmt = $this->db->prepare("DELETE FROM order_items WHERE order_id = :order_id");
            $stmt->execute(['order_id' => $id]);
    
            // Löschen der Bestellung
            $stmt = $this->db->prepare("DELETE FROM orders WHERE id = :id");
            $stmt->execute(['id' => $id]);
    
            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    

}