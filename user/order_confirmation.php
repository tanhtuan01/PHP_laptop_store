<?php $config = require_once (dirname(__DIR__)) . '/config/config.php';  ?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .success-container {
            text-align: center;
            background: #fff;
            padding: 30px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .success-icon {
            font-size: 50px;
            color: #28a745;
        }

        .success-message {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
        }

        .order-details {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="success-container">
        <div class="success-icon">✅</div>
        <div class="success-message">Đặt hàng thành công!</div>
        <div class="order-details">
            Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi.<br>
            Chúng tôi sẽ xử lý đơn hàng của bạn trong thời gian sớm nhất.
        </div>
        <a href="<?php echo $config['BASE_URL']; ?>" class="btn">Tiếp tục mua sắm</a>
    </div>
</body>

</html>