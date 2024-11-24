<?php

session_start();

if (!$_SESSION['user']) {
    header('Location: ../index.php');
}

$config = require_once (dirname(__DIR__)) . '/config/config.php';

require_once (dirname(__DIR__)) . '/db/cart.php';

$cartDb = new Cart();

$cartDetails = $cartDb->getCartDetails($_SESSION['user']['id']);

if (isset($_GET['action'])) {

    if ($_GET['action'] == 'delete') {
        $cartId = $_GET['cartId'];
        $cartDb->delete('t_shopping_cart', $cartId);
        $cartDetails = $cartDb->getCartDetails($_SESSION['user']['id']);
    } else {
        $conditions = [
            'userId' => $_SESSION['user']['id'],
            'productId' => $_GET['pid'],
        ];

        $cart = $cartDb->getOneByColumns('t_shopping_cart', $conditions);
        $quantity = $cart['quantity'];

        $pid = $_GET['pid'];

        if ($_GET['action'] == "up") {
            // up
            $data = [
                'userId' => $_SESSION['user']['id'],
                'productId' => $pid,
                'quantity' => $quantity + 1
            ];
            $cartDb->update('t_shopping_cart', $data, $conditions);
        } else if ($_GET['action'] == "low" && $quantity > 1) {
            // loww
            $data = [
                'userId' => $_SESSION['user']['id'],
                'productId' => $pid,
                'quantity' => $quantity - 1
            ];
            $cartDb->update('t_shopping_cart', $data, $conditions);
        }
        $cartDetails = $cartDb->getCartDetails($_SESSION['user']['id']);
    }
}

if (isset($_POST['submit']) && isset($_POST['selected_products'])) {
    $selectedProducts = $_POST['selected_products'];

    $_SESSION['selected_products'] = $selectedProducts;

    header('Location: order.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <style>
    body {
        font-family: 'Roboto', Arial, sans-serif;
        background-color: #f9fafb;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 50px auto;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .container a {
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
    }

    .container a:hover {
        color: #0056b3;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        font-size: 16px;
    }

    .cart-table th,
    .cart-table td {
        border: 1px solid #ddd;
        padding: 15px;
        text-align: center;
    }

    .cart-table th {
        background-color: #f1f5f9;
        color: #333;
        font-weight: bold;
    }

    .cart-table td a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }

    .cart-table td a:hover {
        color: #0056b3;
    }

    .empty-cart {
        text-align: center;
        padding: 30px;
        background-color: #f9fafb;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .empty-cart h2 {
        font-size: 28px;
        color: #555;
        margin-bottom: 10px;
    }

    .empty-cart p {
        font-size: 16px;
        color: #777;
        margin-bottom: 20px;
    }

    .empty-cart a {
        display: inline-block;
        padding: 12px 25px;
        color: #fff;
        background-color: #007bff;
        text-decoration: none;
        border-radius: 6px;
        font-size: 16px;
    }

    .empty-cart a:hover {
        background-color: #0056b3;
        color: white;
    }

    button {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    button:focus {
        outline: none;
    }
    </style>

</head>

<body>
    <div class="container">
        <a href="<?php echo $config['BASE_URL']; ?>">Trang chủ</a>
        <?php if ($cartDetails && count($cartDetails) > 0): ?>
        <form method="POST" action="cart.php">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Chọn</th>
                        <th>STT</th>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th colspan="2">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                        foreach ($cartDetails as $cart): ?>
                    <tr>
                        <td><input type="checkbox" name="selected_products[]" value="<?php echo $cart['productId']; ?>">
                        </td>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $cart['product_name']; ?></td>
                        <td>
                            <a href="cart.php?action=low&pid=<?php echo $cart['productId']; ?>">➖</a>
                            <?php echo $cart['quantity']; ?>
                            <a href="cart.php?action=up&pid=<?php echo $cart['productId']; ?>">➕</a>
                        </td>
                        <td>
                            <a
                                href="<?php echo $config['HOST'] . "/" . $config['PROJECT_NAME'] . "/views/product.php?id=" . $cart['productId']; ?>">🔍
                                Xem</a>
                        </td>
                        <td>
                            <a href="cart.php?action=delete&cartId=<?php echo $cart['id']; ?>">🗑️ Xóa</a>
                        </td>
                    </tr>
                    <?php $i++;
                        endforeach; ?>
                </tbody>
            </table>
            <br>
            <button type="submit" name="submit">Đặt hàng 🛒</button>
        </form>
        <?php else: ?>
        <div class="empty-cart">
            <h2>🛒 Giỏ hàng của bạn đang trống!</h2>
            <p>Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm.</p>
            <a href="<?php echo $config['BASE_URL']; ?>">Tiếp tục mua sắm</a>
        </div>
        <?php endif; ?>
    </div>

</body>

</html>