<?php

     require_once dirname(dirname(__DIR__)) . '/db/base.php';

    $db = new Database();

    $revenue = $db->findAll('t_revenue');

    $totalPrice = 0;
    foreach($revenue as $r ){
        $totalPrice += $r['price'];
    }

?>

<h3>Doanh thu </h3>

<p>Tổng doanh thu <?php echo (number_format($totalPrice, 0, ',', '.')); ?>VNĐ</p>