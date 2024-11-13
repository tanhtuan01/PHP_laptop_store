<?php

    $products = $db->findAll('t_product')

?>

<div class="products row">
    <?php if ($products): ?>
    <?php $i = 1; foreach ($products as $product): ?>
    <a class="product" href="views/product.php?id=<?php echo $product['id']; ?>">
        <div class="box">
            <div class="image">
                <img src="https://cdn.tgdd.vn/Products/Images/44/311178/asus-vivobook-go-15-e1504fa-r5-nj776w-thumb-600x600.jpg"
                    alt="">
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
                <?php echo $product['price'] . "đ"; ?>
            </strong>
            <!-- <div class="box-p">
                <p class="price-old">14.490.000₫</p>
                <div class="percent">9%</div>
            </div> -->
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
    <?php $i++; endforeach; ?>
    <?php else: ?>
    <p>Không có sản phẩm nào</p>
    <?php endif; ?>

</div>