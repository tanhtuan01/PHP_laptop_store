<?php 

    require_once 'connect.php';

    class Order extends Database{
    
       public function findOrderDetailsByOrderId($orderId) {
            $sql = "
                SELECT 
                    od.orderId,
                    od.productId,
                    od.quantity,
                    od.price,
                    od.totalPrice,
                    p.name AS productName,
                    p.image as image
                FROM 
                    t_order_details AS od
                JOIN 
                    t_product AS p ON od.productId = p.id
                WHERE 
                    od.orderId = :orderId
            ";

            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindValue(":orderId", $orderId, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        function formatOrderStatus($status) {
            switch ($status) {
                case 'pending':
                    return '<span style="color: orange;">Đang chờ xử lý</span>';
                case 'processing':
                    return '<span style="color: blue;">Đang xử lý</span>';
                case 'shipped':
                    return '<span style="color: green;">Đã giao hàng</span>';
                case 'completed':
                    return '<span style="color: #4CAF50;">Hoàn thành</span>';
                case 'cancelled':
                    return '<span style="color: red;">Đã hủy</span>';
                default:
                    return '<span style="color: gray;">Không xác định</span>';
            }
        }

    }

?>