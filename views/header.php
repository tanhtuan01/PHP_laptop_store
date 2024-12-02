<?php 
    $totalQuantity = 0;

    if (isset($_SESSION['user'])) {
        $conditions = [
            'userId' => $_SESSION['user']['id'],
        ];

        $cart = $db->findAll('t_shopping_cart', $conditions);

        foreach ($cart as $item) {
            $totalQuantity += $item['quantity']; 
        }
    }
?>
<div class="header">
    <div class="header-content">
        <div class="top row">
            <div class="logo">
                <a href="<?php echo $config['BASE_URL']; ?>">
                    <img src="<?php echo $config['BASE_URL'] .'/assets/images/iassets/header_logo.png'; ?>" alt="">
                    <div class="name">
                        <?php echo $config['PROJECT_NAME']; ?>
                    </div>
                </a>

            </div>
            <div class="search">
                <div class="box-search">
                    <form action="<?php echo $config['BASE_URL'] . "/views/search.php" ?>" method="GET">
                        <div class="input">
                            <input type="text" placeholder="Bạn tìm gì..." name="q" id="ips">
                            <button><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>

                    </form>
                </div>
            </div>
            <div class="login">
                <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?>
                <a href='<?php echo $config['BASE_URL'] . "/user/profile.php"; ?>'>
                    👤
                    <?php echo $_SESSION['user']['username']; ?></a>
                <?php } else { ?>
                <a href="<?php echo $config['BASE_URL'] . "/login.php"; ?>">
                    👤
                    Đăng nhập</a>
                <?php } ?>
            </div>

            <div class="cart">
                <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?>
                <a href="<?php echo $config['BASE_URL'] . "/user/cart.php"; ?>">
                    🛒
                    Giỏ hàng (<?php echo $totalQuantity ?? 0; ?>)
                </a>
                <?php } else { ?> <a href="<?php echo $config['BASE_URL'] . "/login.php"; ?>">
                    🛒
                    (0)
                </a> <?php } ?>
            </div>
            <div class="address">
                <a href="">
                    📍
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