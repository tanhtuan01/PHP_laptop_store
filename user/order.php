<?php
session_start();

require_once (dirname(__DIR__)) . '/db/base.php';

$config = require_once (dirname(__DIR__)) . '/config/config.php';

$db = new Database();

if (!$_SESSION['user']) {
    header('Location: ../index.php');
}

$user = $db->getOne('t_users', $_SESSION['user']['id']);

if (isset($_SESSION['selected_products'])) {
    $selectedProducts = $_SESSION['selected_products'];

    require_once (dirname(__DIR__)) . '/db/cart.php';
    $cartDb = new Cart();

    $totalAmount = 0;
    $products = [];
    foreach ($selectedProducts as $productId) {
        $cartItem = $cartDb->getOneByColumns('t_shopping_cart', ['userId' => $_SESSION['user']['id'], 'productId' => $productId]);

        if ($cartItem) {
            $product = $cartDb->getOneByColumns('t_product', ['id' => $productId]);
            $product['quantity'] = $cartItem['quantity']; // Gán số lượng từ giỏ hàng vào sản phẩm
            $products[] = $product;
            $totalAmount += $product['quantity'] * ($product['isDiscount'] ? $product['newPrice'] : $product['price']);
        }
    }
} else {
    header('Location: cart.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy thông tin từ form
    $address = $_POST['address'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    // Tạo đơn hàng mới và lưu vào cơ sở dữ liệu
    $orderData = [
        'userId' => $_SESSION['user']['id'],
        'address' => $address,
        'name' => $name,
        'phone' => $phone,
        'status' => 'pending',
        'orderDate' => date('Y-m-d H:i:s'),
        'totalAmount' => $totalAmount
    ];
    $orderId = $db->insertAndGetId('t_orders', $orderData);

    foreach ($products as $product) {
        $orderItemData = [
            'orderId' => $orderId,
            'productId' => $product['id'],
            'quantity' => $product['quantity'],
            'price' => ($product['isDiscount'] ? $product['newPrice'] : $product['price']),
            'totalPrice' => $product['quantity'] * ($product['isDiscount'] ? $product['newPrice'] : $product['price']),
        ];
        $db->insert('t_order_details', $orderItemData);
    }

    foreach ($selectedProducts as $productId) {
        $db->deleteByColumns('t_shopping_cart', ['userId' => $_SESSION['user']['id'], 'productId' => $productId]);
    }

    unset($_SESSION['selected_products']);

    header('Location: order_confirmation.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .order-table th,
        .order-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .order-table th {
            background-color: #f8f8f8;
            color: #555;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Xác nhận đơn hàng</h2>
        <table class="order-table">
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
            <?php foreach ($products as $product):
                $totalPrice = $product['quantity'] * ($product['isDiscount'] ? $product['newPrice'] : $product['price']);
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                    <td><?php echo $product['isDiscount'] ? number_format($product['newPrice'], 0, ',', '.') : number_format($product['price'], 0, ',', '.'); ?>
                        VNĐ</td>
                    <td><?php echo number_format($totalPrice, 0, ',', '.'); ?> VNĐ</td>
                </tr>
            <?php endforeach; ?>
        </table>

        <form method="POST" action="">
            <div class="form-group">
                <label for="address">Địa chỉ giao hàng:</label>
                <input type="text" id="address" name="address" required>
            </div>

            <div class="form-group">
                <label for="name">Họ tên người nhận:</label>
                <input type="text" id="name" name="name" required
                    value="<?php echo htmlspecialchars($user['name'] ?? ""); ?>">
            </div>

            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="text" id="phone" name="phone" required
                    value="<?php echo htmlspecialchars($user['phone'] ?? ""); ?>">
            </div>
            <a href="<?php echo $config['BASE_URL']; ?>" class="button"> Trang chủ</a>
            <button type="submit" class="button">Xác nhận đơn hàng</button>
        </form>
    </div>
</body>

</html>