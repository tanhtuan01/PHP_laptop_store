<?php 

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $brand = $_POST['brand'] ?? null;
        $price = $_POST['price'] ?? null;
        $type = $_POST['type'] ?? null;
        $screen = $_POST['screen'] ?? null;
        $features = isset($_POST['features']) ? explode(",", $_POST['features']) : [];
        $specialTech = isset($_POST['specialTech']) ? explode(",", $_POST['specialTech']) : [];
        $ram = $_POST['ram'] ?? null;

        $products = $productDb->filterProducts($brand, $price, $type, $screen, $features, $specialTech, $ram);
    
    }

?>

<div class="row">
    <div class="title-more">
        <h3 class="title-block">Sản phẩm lọc</h3>
        <a class="btn btn-more" href='<?php echo $config['BASE_URL']; ?>'><i
                class="fa-solid fa-filter-circle-xmark"></i>Xóa bộ lọc</a>
    </div>
</div>
<div class="products row">
    <?php if ($products): ?>
    <?php $i = 1;
        foreach ($products as $product): ?>
    <a class="product" href="views/product.php?id=<?php echo $product['id']; ?>">
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
                <?php echo (number_format($product['price'], 0, ',', '.')) . "đ"; ?>
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
    <?php $i++;
        endforeach; ?>
    <?php else: ?>
    <p>Không có sản phẩm nào</p>
    <?php endif; ?>

</div>