<?php
namespace Inventory\Models;

class Inventory
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getInventoryById($id)
{
    $stmt = $this->db->prepare("
        SELECT p.*, c.name AS category_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.id = :id
    ");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}


    // Abrufen eines einzelnen Produktes (Inventargegenstand) per ID
    public function getAllInventory()
    {
        $stmt = $this->db->query("
            SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Erstellen eines neuen Inventargegenstandes (Produkts)
    public function createInventory($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO products (article_number, name, description, price, quantity, category_id, supplier_id, min_stock_level)
            VALUES (:article_number, :name, :description, :price, :quantity, :category_id, :supplier_id, :min_stock_level)
        ");
        return $stmt->execute($data);
    }

    public function updateInventory($id, $data)
{
    $stmt = $this->db->prepare("
        UPDATE products
        SET name = :name, quantity = :quantity, supplier_id = :supplier_id, category_id = :category_id, min_stock_level = :min_stock_level
        WHERE id = :id
    ");

    // Übergabe der Werte an das Statement
    return $stmt->execute([
        'id' => $id,
        'name' => $data['name'],
        'quantity' => $data['quantity'],
        'supplier_id' => $data['supplier_id'],
        'category_id' => $data['category_id'],
        'min_stock_level' => $data['min_stock_level']
    ]);
}


    // Löschen eines Inventargegenstandes (Produkts)
    public function deleteInventory($id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>
