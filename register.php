<?php

    require_once 'db/connect.php';
    
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

    if ($db->insert('t_users', $data)) {
    echo "Đăng ký thành công cho tên đăng nhập: " . htmlspecialchars($username);
    }

}    

?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng Ký</title>
</head>

<body>
    <h2>Đăng Ký</h2>
    <form method="POST" action="#">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" require_onced><br><br>

        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" require_onced><br><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" require_onced><br><br>

        <button type="submit">Đăng Ký</button>
    </form>
    <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
</body>

</html>