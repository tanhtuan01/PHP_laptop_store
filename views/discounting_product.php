<?php

$products = $db->findAll('t_product', ['isDiscount' => true], 'id', 'DESC', $config['INDEX_PRODUCT_DISCOUNT_NUMBER']);

?>

<div class="row">
    <div class="title-more">
        <h3 class="title-block">Đang giảm giá</h3>
        <a class="btn btn-more" href="views/discounting.php">Xem nhiều hơn</a>
    </div>
</div>

<div class="products row">
    <?php if ($products): ?>
    <?php 
        foreach ($products as $product): ?>
    <a class="product" href="views/product.php?id=<?php echo $product['id']; ?>">
        <div class="tag-discount">
            <div>
                Giảm giá <br> <?php echo $product['percent']; ?>%
            </div>
        </div>
        <div class="box">
            <div class="image">
                <img src="<?php echo $config['BASE_URL'] . '/assets/images/products/' . $product['image']; ?>" alt="">
            </div>
            <div class="gift">
                <span>
                    Tặng Office
                </span>
            </div>
            <h3 class="name">
                <?php echo $product['name']; ?>
            </h3>
            <div class="hardware">
                <span class="tag">RAM<?php echo $product['ram']; ?>GB</span>
                <span class="tag">SSD<?php echo $product['ssd']; ?>GB</span>
            </div>
            <strong class="price">
                <?php echo (number_format($product['newPrice'], 0, ',', '.')) . "đ"; ?>
            </strong>
            <div class="box-p">
                <p class="price-old"> <?php echo (number_format($product['price'], 0, ',', '.')) . "đ"; ?></p>
                <div class="percent"><b>-<?php echo $product['percent'] ?>%</b></div>
            </div>
            <!-- Đang phát triển -->
            <!-- <p class="item-gift">
                Quà <b>1.090.000₫</b>
            </p> -->
            <div class="add-to-cart">
                <button title="Xem sản phẩm" class="view"><i class="fa-regular fa-eye"></i></i>&nbsp;</button>
                <button title="Thêm vào giỏ hàng" class="addtocart"><i
                        class="fa-solid fa-cart-arrow-down"></i>&nbsp;</button>
            </div>
        </div>
    </a>
    <?php 
        endforeach; ?>
    <?php else: ?>
    <p>Không có sản phẩm nào</p>
    <?php endif; ?>

</div>