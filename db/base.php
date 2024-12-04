<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'db_laptop'; //  Chỉnh sửa
    private $username = 'root';     //  Chỉnh sửa
    private $password = '';         //  Chỉnh sửa 
    protected $conn;

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

    public function insertAndGetId($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->conn->prepare($sql);
       
        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
       
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function update($table, $data, $conditions) {
        $setParts = [];
        
        foreach ($data as $key => $value) {
            $setParts[] = "{$key} = :{$key}";
        }
        
        $setSql = implode(", ", $setParts);
        $whereParts = [];
        
        foreach ($conditions as $key => $value) {
            $whereParts[] = "{$key} = :where_{$key}";
        }
        
        $whereSql = implode(" AND ", $whereParts);
        $sql = "UPDATE {$table} SET {$setSql} WHERE {$whereSql}";
        $stmt = $this->conn->prepare($sql);
        
        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":where_{$key}", $value);
        }
        
        return $stmt->execute();
    }


    public function findAll($table, $conditions = [], $orderBy = 'id', $orderDirection = 'DESC', $limit = null) {
        $sql = "SELECT * FROM {$table}";
       
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", array_map(fn($k) => "{$k} = :{$k}", array_keys($conditions)));
        }
       
        $sql .= " ORDER BY {$orderBy} {$orderDirection}";
       
        if ($limit !== null) {
            $sql .= " LIMIT :limit";
        }
       
        $stmt = $this->conn->prepare($sql);
       
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
       
        if ($limit !== null) {
            $stmt->bindValue(":limit", (int)$limit, PDO::PARAM_INT);
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

    public function getOneByColumn($table, $column, $value) {
        $sql = "SELECT * FROM $table WHERE $column = :value";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOneByColumns($table, $conditions) {
        $sql = "SELECT * FROM $table WHERE ";
        $clauses = [];
        $params = [];

        foreach ($conditions as $column => $value) {
            $clauses[] = "$column = :$column";
            $params[":$column"] = $value;
        }

        $sql .= implode(' AND ', $clauses); 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }


    public function delete($table, $id) {
        $sql = "DELETE FROM $table WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteByColumns($table, $conditions) {
        $sql = "DELETE FROM $table WHERE ";
        $conditionStrings = [];
      
        foreach ($conditions as $column => $value) {
            $conditionStrings[] = "$column = :$column";
        }
      
        $sql .= implode(' AND ', $conditionStrings);
        try {
            $stmt = $this->conn->prepare($sql);
          
            foreach ($conditions as $column => $value) {
                $stmt->bindValue(":$column", $value);
            }
          
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Lỗi khi xóa bản ghi: ' . $e->getMessage();
            return false;
        }
    }

    public function search($table, $searchConditions, $orderBy = 'id', $orderDirection = 'ASC') {
        $sql = "SELECT * FROM {$table} WHERE ";
        $conditions = [];
        
        foreach ($searchConditions as $column => $value) {
            $conditions[] = "{$column} LIKE :{$column}";
        }
        
        $sql .= implode(" AND ", $conditions);
        $sql .= " ORDER BY {$orderBy} {$orderDirection}";
        $stmt = $this->conn->prepare($sql);
        
        foreach ($searchConditions as $column => $value) {
            $stmt->bindValue(":{$column}", '%' . $value . '%');
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findWithPagination($table, $conditions = [], $searchKey = null, $searchValue = null, $orderBy = 'id', $orderDirection = 'DESC', $limit = 10, $page = 1) {
        $offset = ($page - 1) * $limit;

        $sql = "SELECT * FROM {$table}";

        $whereClauses = [];
        if ($conditions) {
            foreach ($conditions as $key => $value) {
                $whereClauses[] = "{$key} = :{$key}";
            }
        }

        if ($searchKey && $searchValue) {
            $whereClauses[] = "{$searchKey} LIKE :searchValue";
        }

        if ($whereClauses) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }

        $sql .= " ORDER BY {$orderBy} {$orderDirection}";
        $sql .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }

        if ($searchKey && $searchValue) {
            $stmt->bindValue(":searchValue", "%{$searchValue}%");
        }

        $stmt->bindValue(":limit", (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(":offset", (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $countSql = "SELECT COUNT(*) as total FROM {$table}";
        if ($whereClauses) {
            $countSql .= " WHERE " . implode(" AND ", $whereClauses);
        }

        $countStmt = $this->conn->prepare($countSql);

        foreach ($conditions as $key => $value) {
            $countStmt->bindValue(":{$key}", $value);
        }

        if ($searchKey && $searchValue) {
            $countStmt->bindValue(":searchValue", "%{$searchValue}%");
        }

        $countStmt->execute();
        $total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

        return [
            'data' => $data,
            'total' => $total,
            'current_page' => $page,
            'last_page' => ceil($total / $limit),
        ];
    }



}
?>