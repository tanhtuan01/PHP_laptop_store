<?php 

    require_once 'base.php';

    class Wishlist extends Database{

        public function getProductsFromWishlistWithPagination($userId, $limit, $page) {
            $offset = ($page - 1) * $limit;

            $sql = "
                SELECT p.*, w.id as wid
                FROM t_product p
                JOIN t_wishlists w ON p.id = w.productId
                WHERE w.userId = :userId
                LIMIT :limit OFFSET :offset
            ";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $countSql = "
                SELECT COUNT(*) as total
                FROM t_wishlists
                WHERE userId = :userId
            ";

            $countStmt = $this->conn->prepare($countSql);
            $countStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
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