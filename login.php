<?php
require_once 'db/connect.php';
session_start();
$db = new Database();

$config = require_once 'config/config.php';

if(isset($_SESSION['user'])){
   header("Location: {$config['BASE_URL']}/");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $db->getOneByColumn('t_users', 'username', $username);

    if ($user) {
        // Check password
        if (md5($password) == $user['password']) {
            $_SESSION['user'] = $user;
            header("Location: {$config['BASE_URL']}/");
            exit();
        } else {
            $error = "Mật khẩu không khớp";
        }
    } else {
        $error = "Không có tài khoản";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f3f4f6;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-container {
        background-color: #fff;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    h2 {
        margin-bottom: 1.5rem;
        color: #333;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    input {
        width: 100%;
        padding: 0.8rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
    }

    button {
        width: 100%;
        padding: 0.8rem;
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #45a049;
    }

    .error {
        color: red;
        margin-bottom: 1rem;
    }

    p {
        margin-top: 1rem;
        text-align: center;
    }

    a {
        color: #4caf50;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Đăng Nhập</h2>
        <?php if (!empty($error)) : ?>
        <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Đăng Nhập</button>
        </form>
        <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
    </div>
</body>

</html>