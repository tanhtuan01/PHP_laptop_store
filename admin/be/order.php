<?php 

    $id = $_GET['orderId'];

    $action = $_GET['action'];

    require_once dirname(dirname(__DIR__)) . '/db/connect.php';

    $db = new Database();

   $order = $db->getOne('t_orders', $id);
        
    if($db->update('t_orders', ['status' => $action] , ['id' => $id])){
        if($action == 'completed'){
            $db->insert('t_revenue',['orderId' => $id, 'price' => $order['totalAmount']])   ; 
        }
        header("Location: ../index.php?page=orders&type=success&message=Đã xác nhận đơn hàng"); 
    }else{
        header("Location: ../index.php?page=orders&type=error&message=Có lỗi khi xác nhận đơn hàng"); 
    }
    
?>