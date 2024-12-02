<?php 

    require_once (dirname(__DIR__)) . '/db/base.php';
    
    $db = new Database();

    $config = require_once (dirname(__DIR__)) . '/config/config.php';
    
    if(!isset($_GET['q']) || !$_GET['q']){
        header("Location: ../index.php");
    }

    $q = $_GET['q'];

    $products = $db->search('t_product', ['name' => $q]);
    

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
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/index.css">
</head>

<body>

    <div class="home_page">

        <div class="header">
            <div class="header-content">
                <div class="top row">
                    <div class="logo">
                        <a href="<?php echo $config['HOST'] . '/' . $config['ROOT_FOLDER']; ?>">
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
                <h3>Kết quả tìm kiếm</h3>
            </div>

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
                            <button title="Xem sản phẩm" class="view"><i
                                    class="fa-regular fa-eye"></i></i>&nbsp;</button>
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


            <div class="footer">
                <h1 style="text-align:center">FOOTER</h1>
            </div>
        </div>

</body>

</html>