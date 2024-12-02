<?php

$config = require_once (dirname(__DIR__)) . '/config/config.php';

require_once (dirname(__DIR__)) . '/db/base.php';

$db = new Database();

if (!isset($_GET['id']) || !$_GET['id']) {
    Header('Location: ../index.php');
}

$id = $_GET['id'];

$brand = $db->getOne('t_brand', $id);

$products = $db->findAll('t_product', ['brandId' => $id]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once "lib.php"; ?>
</head>

<body>
    <div class="home_page">

        <?php require_once "header.php"; ?>

        <div class="content">
            <div class="row">
                <h2>Danh sách laptop của "<?php echo $brand['name']; ?>"</h2>
            </div>


            <div class="filter">

                <div class="row">
                    <!-- <div class="ifilter">
                        <a class="item">
                            <i class="fa-solid fa-filter"></i>
                            &nbsp;
                            Lọc
                        </a>
                    </div> -->

                </div>

                <div class="row sort">
                    Sắp xếp theo: <ul>
                        <li>
                            <a href="">Nổi bật</a>
                        </li>
                        <li>
                            <a href="">Bán chạy</a>
                        </li>
                        <li>
                            <a href="">Giảm giá</a>
                        </li>
                        <li>
                            <a href="">Mới</a>
                        </li>
                        <li>
                            <a href="">Giá</a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="products row">
                <?php if ($products): ?>
                <?php $i = 1;
                    foreach ($products as $product): ?>
                <a class="product"
                    href="<?php echo $config['BASE_URL'] . "/views/product.php?id=" . $product['id']; ?>">
                    <?php if($product['isDiscount']){ ?>
                    <div class="tag-discount">
                        <div>
                            Giảm giá <br> <?php echo $product['percent']; ?>%
                        </div>
                    </div>
                    <?php } ?>
                    <div class="box">
                        <div class="image">
                            <img src="<?php echo $config['BASE_URL'] . '/assets/images/products/' . $product['image']; ?>"
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
                            <?php echo (number_format(($product['isDiscount']? $product['newPrice']: $product['price']), 0, ',', '.')) . "đ"; ?>
                        </strong>
                        <?php if($product['isDiscount']){ ?>
                        <div class="box-p">
                            <p class="price-old"> <?php echo (number_format($product['price'], 0, ',', '.')) . "đ"; ?>
                            </p>
                            <div class="percent"><b>-<?php echo $product['percent'] ?>%</b></div>
                        </div>
                        <?php  }?>
                        <!-- Đang phát triển -->
                        <!-- <p class="item-gift">
                Quà <b>1.090.000₫</b>
            </p> -->
                        <div class="add-to-cart">
                            <button title="Xem sản phẩm" class="view"><i
                                    class="fa-regular fa-eye"></i></i>&nbsp;</button>
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
            <?php require_once 'footer.php'; ?>

        </div>
</body>

</html>