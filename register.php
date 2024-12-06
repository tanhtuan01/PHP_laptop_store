<?php
require_once 'db/base.php';

session_start();
$config = require_once 'config/config.php';
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    $data = [
        'username' => $username,
        'phone' => $phone,
        'password' => md5($password),
    ];

    $userId = $db->insertAndGetId('t_users', $data);

    if ($userId) {
        // Hiện đang fix cứng 2 role
        $db->insert('t_user_roles',['userId' => $userId,'roleId'=> 1]);
        $success = "Đăng ký thành công cho tên đăng nhập: " . htmlspecialchars($username);
    } else {
        $error = "Đăng ký không thành công. Vui lòng thử lại!";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptop Store</title>
    <link rel="icon" type="image/x-icon" href="<?php echo $config['BASE_URL'] .'/assets/images/iassets/logo.png'; ?>">
    <?php require_once "views/lib.php"; ?>

    <style>
    .content {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .register-container {
        background-color: #fff;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    .register-container h2 {
        margin-bottom: 1.5rem;
        color: #333;
    }

    .register-container label {
        display: block;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .register-container input {
        width: 100%;
        padding: 0.8rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
    }

    .register-container button {
        width: 100%;
        padding: 0.8rem;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .register-container button:hover {
        background-color: #0056b3;
    }

    .register-container .message {
        margin-bottom: 1rem;
        padding: 1rem;
        border-radius: 5px;
        text-align: center;
    }

    .register-container .success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .register-container .error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .register-container p {
        margin-top: 1rem;
        text-align: center;
    }

    .register-container a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }

    .register-container a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>

    <div class="home_page">

        <?php require_once "views/header.php"; ?>

        <div class="content">
            <div class="register-container">
                <h2>Đăng Ký</h2>
                <?php if (!empty($success)) : ?>
                <div class="message success"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if (!empty($error)) : ?>
                <div class="message error"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST" action="#">
                    <label for="username">Tên đăng nhập:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="phone">Số điện thoại:</label>
                    <input type="text" id="phone" name="phone" required>

                    <label for="password">Mật khẩu:</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit">Đăng Ký</button>
                </form>
                <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
            </div>

        </div>

        <?php require_once 'views/footer.php'; ?>
    </div>


</body>

</html>