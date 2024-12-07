<div class="row">
    <div class="view-product">

        <div class="left">
            <div class="box-left-img">
                <div class="box-main-img">
                    <img class="main-img" id="ProductShowing"
                        src="<?php echo $config['HOST'] . $config['ROOT_FOLDER'] . '/assets/images/products/' . $product['image']; ?>"
                        alt="">
                </div>
                <div class="sub-img">
                    <div class="box-sub-img">
                        <?php 
                    if($productImages){
                        foreach($productImages as $i){ ?>
                        <div class="box-img" onclick="changeImage(this)">
                            <img src="<?php echo $config['PRODUCT_IMAGE'] . $i['image']; ?>" alt="">
                        </div>

                        <?php }} ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="right">
            <h2> <?php echo $product['name']; ?></h2>
            <h3 style="color:red">

                <?php echo $product['isDiscount']
                ?  (number_format($product['newPrice'], 0, ',', '.'))
                : (number_format($product['price'], 0, ',', '.')); ?>đ
            </h3>
            <p>
                CPU: <?php echo $product['cpu']; ?>
            </p>
            <p>
                RAM: <?php echo $product['ram'] . " GB"; ?>
            </p>
            <p>
                SSD: <?php echo $product['ssd'] ; ?>
            </p>
            <p>
                Nặng: <?php echo $product['weight'] . " kg"; ?>
            </p>
            <p>
                Màn hình: <?php echo $product['screen'] . " inch"; ?>
            </p>

            <div class="features">
                <?php if ($specialTechnologies) { echo "<p class='title'>Tính năng:</p>";} ?>
                <ul>
                    <?php if ($productFeatures) {
                        foreach ($productFeatures as $productFeature) { ?>
                    <li><?php echo htmlspecialchars($productFeature['name']); ?></li>
                    <?php }  }  ?>
                </ul>
            </div>

            <div class="special-technologies">
                <?php if ($specialTechnologies) { echo "<p class='title'>Công nghệ đặc biệt:</p>";} ?>

                <ul>
                    <?php if ($specialTechnologies) {
                        foreach ($specialTechnologies as $technology) { ?>
                    <li><?php echo htmlspecialchars($technology['name']); ?></li>
                    <?php }  }  ?>
                </ul>
            </div>

            <div class="view-product-button">
                <?php
                    if ($product['quantity'] > 0) {
                    ?>
                <a class="btn add-to-cart" href='product.php?id=<?php echo $product['id']; ?>&action=add-to-cart'>
                    🛒 Thêm vào giỏ hàng</a>
                <?php } else {
                        echo "Sản phẩm hiện đang hết";
                    } ?>
                <a class="btn add-to-wishlist"
                    href='product.php?id=<?php echo $product['id']; ?>&action=add-to-wishlist'>🔖
                    Thêm vào yêu
                    thích</a>
            </div>

        </div>
    </div>

</div>
<div class="row">
    <div class="desc-info">
        <div class="desc">
            <p class="title">Mô tả</p>
            <pre>
                <?php echo $product['description']; ?>
            </p>
        </div>
        <div class="info">
            <p class="title">Thông tin khác</p>
            <pre>
                <?php echo $product['info']; ?>
            </pre>
        </div>
    </div>
</div>