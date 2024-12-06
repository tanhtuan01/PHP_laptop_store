<?php
require_once 'db/base.php';
require_once 'db/role.php';
session_start();
$db = new Database();
$role = new Role();
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
            // Get role
            $userRole = $role->getRoleByUser($user['id']);
            $_SESSION['user'] = $user;
            $_SESSION['user']['role'] = $userRole;
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

    .login-container {
        background-color: #fff;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    .login-container h2 {
        margin-bottom: 1.5rem;
        color: #333;
    }

    .login-container label {
        display: block;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .login-container input {
        width: 100%;
        padding: 0.8rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
    }

    .login-container button {
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

    .login-container button:hover {
        background-color: #45a049;
    }

    .login-container .error {
        color: red;
        margin-bottom: 1rem;
    }

    .login-container p {
        margin-top: 1rem;
        text-align: center;
    }
    </style>
</head>

<body>

    <div class="home_page">

        <?php require_once "views/header.php"; ?>

        <div class="content">
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

        </div>

        <?php require_once 'views/footer.php'; ?>
    </div>


</body>

</html>