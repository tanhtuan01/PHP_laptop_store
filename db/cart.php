<?php 

    require_once 'connect.php';

    class Cart extends Database{
    
        public function getCartDetails($userId) {
            $sql = "SELECT 
                        sc.*, 
                        u.username, u.email, u.username AS user_name, 
                        p.name AS product_name, p.price, p.image 
                    FROM 
                        t_shopping_cart sc
                    JOIN 
                        t_users u ON sc.userId = u.id
                    JOIN 
                        t_product p ON sc.productId = p.id
                    WHERE 
                        sc.userId = :userId";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        
    }

?>