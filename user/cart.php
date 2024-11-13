<?php 

    session_start();

    if(!$_SESSION['user']){
        header('Location: ../index.php');
    }

     $config = require_once (dirname(__DIR__)) . '/config/config.php';
    
    require_once (dirname(__DIR__)) . '/db/cart.php';
    
    
    $cartDb = new Cart();
    
    $cartDetails = $cartDb->getCartDetails($_SESSION['user']['id']);

    if(isset($_GET['action'])){

        if($_GET['action'] == 'delete'){
            $cartId = $_GET['cartId'];
            $cartDb->delete('t_shopping_cart', $cartId);
            $cartDetails = $cartDb->getCartDetails($_SESSION['user']['id']);
        }

        
        else{

             $conditions = [
            'userId' => $_SESSION['user']['id'],
            'productId' => $_GET['pid'],
        ];

        $cart = $cartDb->getOneByColumns('t_shopping_cart', $conditions);
            $quantity = $cart['quantity'];
        
            $pid =$_GET['pid'];
        
            if($_GET['action'] == "up"){
            // up
                $data = [
                    'userId' => $_SESSION['user']['id'],
                    'productId' => $pid,
                    'quantity' => $quantity + 1
                ];
                $cartDb->update('t_shopping_cart', $data, $conditions);

            }else if($_GET['action'] == "low" && $quantity > 1){
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

    if(isset($_POST['submit']) && isset($_POST['selected_products'])){
        $selectedProducts = $_POST['selected_products'];
        
        $_SESSION['selected_products'] = $selectedProducts;

        header('Location: order.php');
        exit();  
    }

?>

<style>
a {
    text-decoration: none
}
</style>

<title>Giỏ hàng </title>

<a href="../index.php">Trang chủ </a>
<form method="POST" action="cart.php">
    <table style="width: 100%; text-align: center" cellpadding="10" cellspacing="0" border="1">
        <tr>
            <th>Chọn</th>
            <th>STT</th>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th colspan="2">Thao tác</th>
        </tr>
        <?php $i = 1; foreach ($cartDetails as $cart): ?>
        <tr>
            <td>
                <input type="checkbox" name="selected_products[]" value="<?php echo $cart['productId']; ?>">
            </td>
            <td><?php echo $i; ?></td>
            <td><?php echo $cart['product_name']; ?></td>
            <td>
                <a href="cart.php?action=low&pid=<?php echo $cart['productId'];?>">-</a>
                <?php echo $cart['quantity']; ?>
                <a href="cart.php?action=up&pid=<?php echo $cart['productId'];?>">+</a>
            </td>
            <td>
                <a
                    href="<?php echo $config['HOST'] . "/" .$config['PROJECT_NAME'] . "/views/product.php?id=". $cart['productId']; ?>">Xem</a>
            </td>

            <td>
                <a href="cart.php?action=delete&cartId=<?php echo $cart['id']; ?>">Xóa</a>
            </td>

        </tr>
        <?php $i++; endforeach; ?>
    </table>

    <?php if($cartDetails && count($cartDetails) > 0) { ?>
    <br> <button type="submit" name="submit">Đặt hàng</button>
    <?php } ?>
</form>