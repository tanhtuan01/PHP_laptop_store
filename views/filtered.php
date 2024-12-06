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
    <?php  foreach ($products as $product): ?>
    <a class="product" href="<?php echo $config['BASE_URL'] . '/views/product.php?id=' . $product['id'] ?>
">
        <?php if($product['isDiscount']) { ?>
        <div class="tag-discount">
            <div>
                Giảm giá <br> <?php echo $product['percent']; ?>%
            </div>
        </div>
        <?php } ?>
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
            <strong class="price">
                <?php echo (number_format($product['isDiscount'] ? $product['newPrice'] : $product['price'], 0, ',', '.')); ?>đ
            </strong>
            <?php if($product['isDiscount']) { ?>
            <div class="box-p">
                <p class="price-old"> <?php echo (number_format($product['price'], 0, ',', '.')) . "đ"; ?></p>
                <div class="percent"><b>-<?php echo $product['percent'] ?>%</b></div>
            </div>
            <?php } ?>
            <div class="add-to-cart">
                <button title="Xem sản phẩm" class="view"><i class="fa-regular fa-eye"></i></i>&nbsp;</button>
                <button title="Thêm vào giỏ hàng" class="addtocart"><i
                        class="fa-solid fa-cart-arrow-down"></i>&nbsp;</button>
            </div>
        </div>
    </a>
    <?php  endforeach; ?>
    <?php else: ?>
    <p>Không có sản phẩm nào</p>
    <?php endif; ?>

</div>