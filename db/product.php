<?php

require_once 'base.php';

class Product extends Database
{
    public function productFilterPagination(
        $table,
        $conditions = [],
        $orderBy = 'id',
        $orderDirection = 'DESC',
        $limit = 10,
        $page = 1
    ) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM {$table}";
        $whereClauses = [];
        $params = [];

        foreach ($conditions as $key => $value) {
            if (is_array($value)) {
                if (strpos($key, 'BETWEEN') !== false) {
                    $whereClauses[] = $key;
                    foreach ($value as $paramValue) {
                        $params[] = $paramValue;
                    }
                } elseif (strpos($key, 'IN') !== false) {
                    $placeholders = implode(',', array_fill(0, count($value), '?'));
                    $whereClauses[] = "{$key} ({$placeholders})";
                    $params = array_merge($params, $value);
                }
            } else {
                $whereClauses[] = "{$key} = ?";
                $params[] = $value;
            }
        }

        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(' AND ', $whereClauses);
        }

        // Chèn trực tiếp giá trị LIMIT và OFFSET vào SQL
        $sql .= " ORDER BY {$orderBy} {$orderDirection} LIMIT {$limit} OFFSET {$offset}";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $countSql = "SELECT COUNT(*) as total FROM {$table}";
        if (!empty($whereClauses)) {
            $countSql .= " WHERE " . implode(' AND ', $whereClauses);
        }

        $countStmt = $this->conn->prepare($countSql);
        $countStmt->execute($params);
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