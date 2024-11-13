<?php

	require_once 'db/connect.php';
    
	session_start();
	
    $db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

	$user = $db->getOneByColumn('t_users','username',$username);

	if($user){
		
		// Check password
		if(md5($password) == $user['password']){
 			$_SESSION['user'] = $user;
			header("Location: index.php");
			// echo "Mật khẩu khớp";
			exit();
		}else{
			echo "Mật khẩu không khớp";
		}

	}else{
		echo "Không có tài khoản";
	}

}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
</head>

<body>
    <h2>Đăng Nhập</h2>
    <form method="POST" action="">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" require_onced><br><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" require_onced><br><br>

        <button type="submit">Đăng Nhập</button>
    </form>
    <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
</body>

</html>