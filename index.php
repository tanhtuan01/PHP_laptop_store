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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>

    <div class="home_page">

        <div class="header">
            <div class="header-content">
                <div class="top row">
                    <div class="logo">
                        <a href="<?php echo $config['HOST'] . '/' . $config['PROJECT_NAME']; ?>">
                            Trang chủ
                            <!-- <img src="https://fecredit.com.vn/wp-content/uploads/2018/12/thegioididong.png" alt=""> -->
                        </a>
                    </div>
                    <div class="search">
                        <div class="box-search">
                            <form action="views/search.php" method="GET">
                                <div class="input">
                                    <input type="text" placeholder="Bạn tìm gì..." name="q" id="ips">
                                    <button><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="login">
                        <?php  if (isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?>
                        <a href='user/profile.php'><i class="fa-solid fa-user"></i>
                            <?php echo $_SESSION['user']['username']; ?></a>
                        <?php } else{ ?>
                        <a href="login.php"><i class="fa-solid fa-user"></i>
                            Đăng nhập</a>
                        <?php } ?>
                    </div>

                    <div class="cart">
                        <?php  if (isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?>
                        <a href="user/cart.php">
                            <i class="fa-solid fa-cart-shopping"></i>
                            Giỏ hàng
                        </a>
                        <?php } else{ ?> Cần đăng nhập <?php } ?>
                    </div>
                    <div class="address">
                        <a href="">
                            <i class="fa-solid fa-location-dot"></i>
                            Hà Nội
                        </a>
                        <i class="fa-solid fa-chevron-right sub-icon"></i>
                    </div>
                </div>
                <div class="sub-row">
                    <div class="new"></div>
                    <div class="old"></div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">
                <h3>Trang Chủ</h3>
            </div>

            <div class="row" style="padding: 10px 0;">
                <h3>Đang giảm giá</h3>
                <span>
                    Đang phát triển
                </span>
            </div>


            <div class="row">
                <h3>Danh Mục Laptop</h3>

            </div>
            <div class="row">
                <div class="category">
                    <a href="" class="item">
                        <img src="https://cdnv2.tgdd.vn/mwg-static/common/Category/44/10/4410b95393b8e2be4065f181932cf3b9.png"
                            alt="">
                    </a>
                    <a href="" class="item">
                        <img src="https://cdnv2.tgdd.vn/mwg-static/common/Category/7b/25/7b256aa49ccc53d2fafc71aeff1da981.png"
                            alt="">
                    </a>
                    <a href="" class="item">
                        <img src="https://cdnv2.tgdd.vn/mwg-static/common/Category/5e/8e/5e8e0225b7f45864fb8c4dbf7b151533.png"
                            alt="">
                    </a>
                    <a href="" class="item">
                        <img src="https://cdnv2.tgdd.vn/mwg-static/common/Category/16/20/1620a7d46f9bd765e33d9e291567e90a.png"
                            alt="">
                    </a>
                    <a href="" class="item">
                        <img src="https://cdnv2.tgdd.vn/mwg-static/common/Category/93/b6/93b61bcd1237eb7871ba30a003e2352e.png"
                            alt="">
                    </a>
                    <a href="" class="item">
                        <img src="https://cdnv2.tgdd.vn/mwg-static/common/Category/64/7a/647a7e93e952189ac77d9b26a9c0637e.png"
                            alt="">
                    </a>
                </div>
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


            <?php require_once 'views/list_product.php'; ?>

            <div class="footer">
                <h1 style="text-align:center">FOOTER</h1>
            </div>
        </div>

</body>

</html>