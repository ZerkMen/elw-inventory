<?php

namespace Inventory\Models;

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllUsers()
    {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY username");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createUser($data)
    {
        $stmt = $this->db->prepare("INSERT INTO users (username, password, email, avatar_path, role) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['username'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['email'],
            $data['avatar_path'],
            $data['role']
        ]);
    }

    public function updateUser($id, $data)
    {
        $sql = "UPDATE users SET username = ?, email = ?, role = ?";
        $params = [$data['username'], $data['email'], $data['role']];

        if (!empty($data['password'])) {
            $sql .= ", password = ?";
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if (!empty($data['avatar_path'])) {
            $sql .= ", avatar_path = ?";
            $params[] = $data['avatar_path'];
        }

        $sql .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function deleteUser($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}