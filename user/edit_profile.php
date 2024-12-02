<?php 

    session_start();

    $config = require dirname(__DIR__) . '/config/config.php';

    require_once dirname(__DIR__) . '/db/base.php';


    $db = new Database();

    if(!isset($_SESSION['user'])){
        Header("location: {$config['BASE_URL']}/login.php");
    }
    $user = $_SESSION['user'];

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $email = trim($_POST['email']);

    $db->update('t_users',[
        'name' => $name,
        'phone' => $phone,
        'address' => $address,
        'email' => $email
    ],['id' => $user['id']]);
    
    Header('Location: profile.php');
   }

   

?>