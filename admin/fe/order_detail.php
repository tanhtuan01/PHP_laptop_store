<?php 
    require_once dirname(dirname(__DIR__)) . '/db/connect.php';

    $db = new Database();

    require_once dirname(dirname(__DIR__)) . '/db/order.php';
    
    $orderDb = new Order();

    $order = $db->getOne('t_orders', $id);

    $orderDetails = $orderDb->findOrderDetailsByOrderId($id);


?>

<h3>Chi tiết đơn đặt hàng</h3>

<p>
    Trạng thái: <?php echo $orderDb->formatOrderStatus($order['status']); ?>
</p>

<table style="width: 100%; text-align: center" cellpadding="10" cellspacing="0" border="1">

    <tr>
        <th>STT</th>
        <th>Sản phẩm</th>
        <th>Số lượng</th>
        <th>Giá tiền</th>
        <th>Thành tiền </th>
    </tr>

    <?php if($orderDetails){ ?>
    <?php $i = 1; foreach ($orderDetails as $orderDetail): ?>
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $orderDetail['productName']; ?></td>
        <td><?php echo $orderDetail['quantity']; ?></td>
        <td><?php echo (number_format($orderDetail['price'], 0, ',', '.')); ?> VNĐ</td>
        <td><?php echo (number_format($orderDetail['totalPrice'], 0, ',', '.')); ?> VNĐ</td>
    </tr>
    <?php $i++; endforeach; } ?>

</table>

<?php if($order['status'] != 'processing'){ ?>

<a href="be/order.php?orderId=<?php echo $id; ?>&action=processing">Xác nhận đơn hàng</a>

<?php } ?>


<?php if($order['status'] == 'processing'){ ?>

<a href="be/order.php?orderId=<?php echo $id; ?>&action=completed">Hoàn thành đơn hàng</a>

<?php } ?>