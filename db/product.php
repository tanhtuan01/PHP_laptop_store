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

    public function getProductFeatures($productId){
        $sql = "
            SELECT 
                f.name,
                f.description
            FROM 
                t_product p
            JOIN 
                t_product_feature pf ON p.id = pf.productId
            JOIN t_features
                f on pf.featureId = f.id
            WHERE 
                p.id = :productId;
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);

        $stmt->execute();

        $productFeatures = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $productFeatures;
    }

    public function getProductSpecialTechs($productId){
        $sql = "
            SELECT 
                f.name,
                f.description
            FROM 
                t_product p
            JOIN 
                t_product_special_tech psc ON p.id = psc.productId
            JOIN t_special_tech
                f on psc.specialtechId = f.id
            WHERE 
                p.id = :productId;
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);

        $stmt->execute();

        $productFeatures = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $productFeatures;
    }

    public function filterProducts($brand, $price, $type, $screen, $features, $specialTech, $ram)
    {
        $sql = "
            select p.* FROM t_product p
            JOIN t_brand b on p.brandId = b.id
            LEFT JOIN t_type t on p.typeId = t.id
            LEFT JOIN t_product_feature pf on p.id = pf.productId
            LEFT JOIN t_features f on pf.featureId = f.id
            LEFT JOIN t_product_special_tech pst on p.id = pst.productId
            LEFT JOIN t_special_tech st on pst.specialtechId = st.id
            WHERE 1=1
        ";

        $params = [];

        if ($brand) {
            $sql .= " AND p.brandId = {$brand}";
        }

        if ($ram) {
            $sql .= " AND p.ram = {$ram}";
        }

        if ($price) {
            $sql .= " AND p.price {$price}";
        }

        if ($type) {
            $sql .= " AND p.typeId = {$type}";
        }

        if ($screen) {
            $sql .= " AND p.screen = {$screen}";
        }

        if (!empty($features)) {
            $filteredFeatures = array_filter($features, function($value) {
                return !empty($value);
            });

            if (!empty($filteredFeatures)) {
                $featuresPlaceholders = implode(",", array_fill(0, count($filteredFeatures), "?"));
                $sql .= " AND f.id IN ($featuresPlaceholders)";
                $params = array_merge($params, $filteredFeatures);
            }
        }


        if (!empty($specialTech)) {
            $filteredSpecialTech = array_filter($specialTech, function($value) {
                return !empty($value);
            });

            if (!empty($filteredSpecialTech)) {
                $specialTechPlaceholders = implode(",", array_fill(0, count($filteredSpecialTech), "?"));
                $sql .= " AND st.id IN ($specialTechPlaceholders)";
                $params = array_merge($params, $filteredSpecialTech);
            }
        }

        $sql .= " GROUP BY(p.id)";

        // Query String
        $sqlWithParams = $sql;
        foreach ($params as $param) {
            $sqlWithParams = preg_replace('/\?/', "'$param'", $sqlWithParams, 1); 
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $productFiltered = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $productFiltered;
    }

}

?>