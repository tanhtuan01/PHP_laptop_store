<?php

session_start();

require_once 'db/connect.php';

$config = require 'config/config.php';

$db = new Database();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once "views/lib.php"; ?>
</head>

<body>

    <div class="home_page">

        <?php require_once "views/header.php"; ?>


        <div class="content">
            <div class="row">
                <?php require_once "views/slider.php"; ?>
            </div>

            <div class="row">
                <h3>Danh Mục Laptop</h3>
                <?php require_once 'views/list_brand.php'; ?>
            </div>

            <div class="row" style="padding: 10px 0;">
                <h3>Đang giảm giá</h3>
            </div>
            <?php require_once 'views/discounting_product.php'; ?>

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

            <?php require_once 'views/list_product.php'; ?>
            <?php require_once 'views/footer.php'; ?>

        </div>

        <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js">
        </script>

        <script>
        $(document).ready(function() {
            $('.slider').slick({
                dots: true,
                infinite: true,
                // speed: 500,
                fade: true,
                cssEase: 'linear',
                // autoplay: true,
                arrows: true,
                prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
                nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>"
            });
        });
        </script>
</body>

</html>