<?php 

    session_start();

    $config = require_once (dirname(__DIR__)) . '/config/config.php';

    session_unset(); 

    Header("Location: {$config['BASE_URL']}/");

?>