<div class="view-product">

    <div class="left">
        <img src="<?php echo $config['HOST'] . $config['ROOT_FOLDER'] . '/assets/images/products/' . $product['image']; ?>"
            alt="">
    </div>

    <div class="right">
        <h2> <?php echo $product['name']; ?></h2>
        <p>
            CPU: <?php echo $product['cpu']; ?>
        </p>
        <p>
            RAM: <?php echo $product['ram'] . "GB"; ?>
        </p>
        <p>
            SSD: <?php echo $product['ssd'] . "GB"; ?>
        </p>
        <p>
            Nặng: <?php echo $product['weight'] . "kg"; ?>
        </p>
        <p>
            Màn hình: <?php echo $product['screen'] . "inch"; ?>
        </p>
        <p>

            <?php echo $product['isDiscount']
                ?  (number_format($product['newPrice'], 0, ',', '.'))
                : (number_format($product['price'], 0, ',', '.')); ?>đ
        </p>
        <?php
        if ($product['quantity'] > 0) {
        ?>
        <a href='product.php?id=<?php echo $product['id']; ?>&action=add-to-cart'>Thêm vào giỏ hàng</a>
        <?php } else {
            echo "Sản phẩm hiện đang hết";
        } ?>
        <a href='product.php?id=<?php echo $product['id']; ?>&action=add-to-wishlist'>Thêm vào yêu thích</a>

    </div>
</div>