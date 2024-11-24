<?php

session_start();

$config = require_once (dirname(__DIR__)) . '/config/config.php';

require_once (dirname(__DIR__)) . '/db/connect.php';

$db = new Database();

if (!isset($_GET['id']) || !$_GET['id']) {
    header("Location: ../index.php");
}

$id = $_GET['id'];

$product = $db->getOne('t_product', $id);
if (isset($_SESSION['user'])) {
    // header('Location: ../index.php');
    // Check exists user cart
    $conditions = [
        'userId' => $_SESSION['user']['id'],
        'productId' => $id
    ];

    $cart = $db->getOneByColumns('t_shopping_cart', $conditions);

    if (isset($_GET['action']) && $_GET['action'] === 'add-to-cart') {

        if (!$cart || !$cart['quantity']) {
            // add new
            $data = [
                'quantity' => 1,
                'userId' => $_SESSION['user']['id'],
                'productId' => $id
            ];
            $db->insert('t_shopping_cart', $data);
            $cart = $db->getOneByColumns('t_shopping_cart', $conditions);
        } else {
            // exist cart
            $quantity = $cart['quantity'];
            $data = [
                'quantity' => $quantity + 1,
                'userId' => $_SESSION['user']['id'],
                'productId' => $id
            ];
            $conditions = [
                'userId' => $_SESSION['user']['id'],
                'productId' => $id
            ];
            if ($db->update('t_shopping_cart', $data, $conditions)) {
                echo "Thêm vào giỏ hàng thành công";
                $cart = $db->getOneByColumns('t_shopping_cart', $conditions);
            } else {
                echo "Thêm vào giỏ hàng thất bại";
            }
        }
    } else {
        //add-to-wishlist
    }
} else {
    if (isset($_GET['action']) && ($_GET['action'] === 'add-to-cart' || $_GET['action'] === 'add-to-wishlist')) {
        header("Location: ../login.php");
    }
}


?>

<title>Xem sản phẩm <?php echo $product['name']; ?></title>

<!-- css tmp declare here -->
<style>
.view-product {
    display: flex;
    width: 800px;
    margin: auto
}

.view-product .left {
    margin-right: 10px;
}

.view-product .left img {
    width: 300px;
    height: 300px;
}
</style>
<h2>Xem sản phẩm </h2>
<a href="<?php echo $config['BASE_URL']; ?>  ">Trang chủ </a>
<?php if (isset($_SESSION['user'])) { ?>
<div>
    <a href="<?php echo $config['BASE_URL'] . '/user/cart.php'; ?>">Giỏ hàng
        (<span><?php echo isset($cart['quantity']) ? $cart['quantity'] : 0; ?></span>)</a>
</div>
<?php } else { ?>
<div>
    <a href="<?php echo $config['BASE_URL'] . '/login.php'; ?>">Giỏ hàng (<span>0</span>)</a>
</div>
<?php } ?>

<style>
/* Container chính */
.view-product {
    display: flex;
    flex-wrap: wrap;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    max-width: 900px;
    overflow: hidden;
    width: 100%;
}

/* Phần hình ảnh */
.view-product .left {
    flex: 1;
    min-width: 350px;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.view-product .left img {
    max-width: 100%;
    max-height: 400px;
    border-radius: 8px;
    object-fit: contain;
    transition: transform 0.3s ease-in-out;
}

.view-product .left img:hover {
    transform: scale(1.05);
}

/* Phần thông tin sản phẩm */
.view-product .right {
    flex: 2;
    padding: 30px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.view-product .right h2 {
    font-size: 28px;
    color: #222;
    margin-bottom: 16px;
    font-weight: 600;
}

.view-product .right p {
    margin: 8px 0;
    font-size: 18px;
    color: #555;
}

.view-product .right .price {
    font-size: 26px;
    color: #e63946;
    font-weight: 700;
    margin: 16px 0;
}

.view-product .right .old-price {
    font-size: 18px;
    color: #aaa;
    text-decoration: line-through;
    margin-left: 10px;
}

.view-product .right .actions {
    display: flex;
    gap: 12px;
    margin-top: 20px;
}

.view-product .right .actions a {
    flex: 1;
    text-align: center;
    padding: 12px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    color: #ffffff;
    background-color: #007bff;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.view-product .right .actions a:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

/* Phần "sản phẩm hết hàng" */
.view-product .right .out-of-stock {
    font-size: 18px;
    color: #ff6b6b;
    margin-top: 16px;
    font-weight: 600;
    text-transform: uppercase;
}
</style>

<div class="view-product">

    <div class="left">
        <img src="<?php echo $config['HOST'] . $config['PROJECT_NAME'] . '/assets/images/products/' . $product['image']; ?>"
            alt="">
    </div>

    <div class="right">
        <h2> <?php echo $product['name']; ?></h2>
        <p>
            CPU: <?php echo $product['cpu']; ?>
        </p>
        <p>
            RAM: <?php echo $product['ram'] . "GB"; ?>
        </p>
        <p>
            SSD: <?php echo $product['ssd'] . "GB"; ?>
        </p>
        <p>
            Nặng: <?php echo $product['weight'] . "kg"; ?>
        </p>
        <p>
            Màn hình: <?php echo $product['screen'] . "inch"; ?>
        </p>
        <p>

            <?php echo $product['isDiscount']
                ?  (number_format($product['newPrice'], 0, ',', '.'))
                : (number_format($product['price'], 0, ',', '.')); ?>đ
        </p>
        <?php
        if ($product['quantity'] > 0) {
        ?>
        <a href='product.php?id=<?php echo $product['id']; ?>&action=add-to-cart'>Thêm vào giỏ hàng</a>
        <?php } else {
            echo "Sản phẩm hiện đang hết";
        } ?>
        <a href='product.php?id=<?php echo $product['id']; ?>&action=add-to-wishlist'>Thêm vào yêu thích</a>

    </div>
</div>