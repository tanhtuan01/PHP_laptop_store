<!-- css tmp declare here -->
<style>

</style>
<h2>Xem sản phẩm </h2>
<a href="<?php echo $config['BASE_URL']; ?>  ">Trang chủ </a>
<?php if (isset($_SESSION['user'])) { ?>
<div>
    <a href="<?php echo $config['BASE_URL'] . '/user/cart.php'; ?>">Giỏ hàng
        (<span><?php echo isset($totalQuantity) ? $totalQuantity : 0; ?></span>)</a>
</div>
<?php } else { ?>
<div>
    <a href="<?php echo $config['BASE_URL'] . '/login.php'; ?>">Giỏ hàng (<span>0</span>)</a>
</div>
<?php } ?>

<style>
/* Container chính */
</style>