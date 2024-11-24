<?php

require_once 'connect.php';

class Order extends Database
{

    public function findOrderDetailsByOrderId($orderId)
    {
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

    function getOrdersUserId($userId)
    {

        $sql = "
            SELECT 
                o.id AS orderId,
                o.orderDate,
                o.totalAmount,
                o.status,
                od.id AS orderDetailId,
                od.productId,
                od.quantity,
                od.price
            FROM 
                t_orders o
            JOIN 
                t_order_details od ON o.id = od.orderId
            WHERE 
                o.userId = :userId;
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        $stmt->execute();

        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $orderDetails;
    }

    // Khi xác nhận hoàn thành đơn hàng
    // Cập nhật số lượng đã bán vào bảng t_product
    function updateToProductSoldQuantity($orderId)
    {
        $query = "
            SELECT 
                productId, 
                quantity
            FROM 
                t_order_details 
            WHERE 
                orderId = :orderId 
            GROUP BY 
                productId
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($orderDetails)) {
            echo "Không tìm thấy sản phẩm trong đơn hàng.";
            return;
        }

        foreach ($orderDetails as $detail) {
            $updateQuery = "
                UPDATE 
                    t_product 
                SET 
                    sold = sold + :quantity, 
                    quantity = quantity - :quantity 
                WHERE 
                    id = :productId
            ";

            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':quantity', $detail['quantity'], PDO::PARAM_INT);
            $updateStmt->bindParam(':productId', $detail['productId'], PDO::PARAM_INT);
            $updateStmt->execute();
        }
    }

    function formatOrderStatus($status)
    {
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