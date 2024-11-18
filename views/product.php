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

<a href="../index.php">Trang chủ </a>
<?php
if (isset($_SESSION['user']) && $cart) {
?>
    <div>
        <a href="../user/cart.php">Giỏ hàng (<span><?php echo $cart['quantity']; ?></span>)</a>
    </div>

<?php } else { ?>
    <div>
        <a href="#!">Giỏ hàng (<span>0</span>)</a>
    </div>
<?php } ?>

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
            <?php echo $product['price'] . "đ"; ?>
        </p>
        <a href='product.php?id=<?php echo $product['id']; ?>&action=add-to-cart'>Thêm vào giỏ hàng</a>
        <a href='product.php?id=<?php echo $product['id']; ?>&action=add-to-wishlist'>Thêm vào yêu thích</a>

    </div>
</div>