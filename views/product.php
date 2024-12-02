<?php

session_start();

$config = require_once (dirname(__DIR__)) . '/config/config.php';

require_once (dirname(__DIR__)) . '/db/base.php';

$db = new Database();

if (!isset($_GET['id']) || !$_GET['id']) {
    header("Location: ../index.php");
}

$id = $_GET['id'];

$product = $db->getOne('t_product', $id);
if (isset($_SESSION['user'])) {

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
                // echo "Thêm vào giỏ hàng thành công";
            } else {
                // echo "Thêm vào giỏ hàng thất bại";
            }
        }
    } else {
        //add-to-wishlist
        $wishlist = $db->getOneByColumns('t_wishlists', 
        [
            'userId' => $_SESSION['user']['id'],
            'productId' => $id,
        ]);

        if(!$wishlist) {
            $db->insert('t_wishlists',[
                'userId' => $_SESSION['user']['id'],
                'productId' => $id,
            ]);
            header("Location: {$config['BASE_URL']}/views/product.php?id={$id}");

        }
    }

} else {
    if (isset($_GET['action']) && ($_GET['action'] === 'add-to-cart' || $_GET['action'] === 'add-to-wishlist')) {
        header("Location: ../login.php");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm <?php echo $product['name']; ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo $config['BASE_URL'] .'/assets/images/iassets/logo.png'; ?>">
    <?php require_once "lib.php"; ?>
</head>

<body>

    <div class="home_page">

        <?php require_once "header.php"; ?>

        <div class="content">

            <?php require_once 'view_product.php'; ?>

            <br>
            <?php require_once 'footer.php'; ?>

        </div>


</body>

</html>