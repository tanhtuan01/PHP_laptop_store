<?php

session_start();

require_once 'db/base.php';

$config = require 'config/config.php';

$db = new Database();



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptop Store</title>
    <link rel="icon" type="image/x-icon" href="<?php echo $config['BASE_URL'] .'/assets/images/iassets/logo.png'; ?>">
    <?php require_once "views/lib.php"; ?>
</head>

<body>

    <div class="home_page">

        <?php require_once "views/header.php"; ?>

        <div class="content">
            <?php require_once "views/slider.php"; ?>

            <?php require_once 'views/filter_search.php'; ?>

            <?php require_once 'views/list_brand.php'; ?>

            <?php require_once 'views/discounting_product.php'; ?>

            <!-- <div class="filter">

                <div class="row">
                    <div class="ifilter">
                        <a class="item">
                            <i class="fa-solid fa-filter"></i>
                            &nbsp;
                            Lọc
                        </a>
                    </div>

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

            </div> -->

            <?php require_once 'views/list_product.php'; ?>

        </div>

        <?php require_once 'views/footer.php'; ?>
    </div>

    <?php require_once 'views/scripts.php'; ?>

</body>

</html>