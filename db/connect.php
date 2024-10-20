<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'laptop_store';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
    }

    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->conn->prepare($sql);
        
        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        
        return $stmt->execute();
    }

      public function findAll($table, $conditions = [], $orderBy = 'id', $orderDirection = 'DESC') {
        $sql = "SELECT * FROM {$table}";

        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", array_map(fn($k) => "{$k} = :{$k}", array_keys($conditions)));
        }

        $sql .= " ORDER BY {$orderBy} {$orderDirection}";

        $stmt = $this->conn->prepare($sql);
        
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public function getOne($table, $id) {
        $sql = "SELECT * FROM $table WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($table, $id) {
        $sql = "DELETE FROM $table WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>