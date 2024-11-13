<?php
session_start();

require_once (dirname(__DIR__)) . '/db/connect.php';  

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
            $totalAmount += $product['quantity'] * $product['price'];
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
            'price' => $product['price'],
            'totalPrice' => $product['quantity'] * $product['price']
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

<form method="POST" action="">
    <h2>Đặt hàng của bạn</h2>
    <table style="width: 100%; text-align: center" cellpadding="10" cellspacing="0" border="1">
        <tr>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Thành tiền</th>
        </tr>
        <?php foreach ($products as $product): 
            $totalPrice = $product['quantity'] * $product['price']; 
        ?>
        <tr>
            <td><?php echo $product['name']; ?></td>
            <td><?php echo $product['quantity']; ?></td>
            <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</td>
            <td><?php echo number_format($totalPrice, 0, ',', '.'); ?> VNĐ</td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div>
        <div>
            <label for="address">Địa chỉ giao hàng:</label>
            <input type="text" id="address" name="address" require_onced>
        </div>

        <div>
            <label for="name">Họ tên người nhận:</label>
            <input type="text" id="name" name="name" require_onced value="<?php echo $user['name'] ?? ""; ?>">
        </div>

        <div>
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" require_onced value="<?php echo $user['phone'] ?? "" ; ?>">
        </div>
    </div>

    <button type="submit">Xác nhận đơn hàng</button>
</form>