<?php

require_once dirname(dirname(__DIR__)) . '/db/base.php';

$targePath = dirname(dirname(__DIR__)) . '/assets/images/products/';

$db = new Database();

// Kiểm tra nếu thư mục tồn tại
if (!is_dir($targePath)) {
    echo "Thư mục đích không tồn tại.";
    exit();
}

if ($_POST && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $ram = $_POST['ram'];
    $ssd = $_POST['ssd'];
    $hdd = $_POST['hdd'];
    $weight = $_POST['weight'];
    $screen = $_POST['screen'];
    $cpu = $_POST['cpu'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $info = $_POST['info'];
    $isDiscount = isset($_POST['isDiscount']) ? true : false;
    $percent = isset($_POST['discountPercent']) ? $_POST['discountPercent'] : 0;
    $newPrice = isset($_POST['newPrice']) ? $_POST['newPrice'] : 0;

    $features = isset($_POST['features']) ? $_POST['features'] : []; 

    $specialTechnologies = isset($_POST['specialTechnologies']) ? $_POST['specialTechnologies'] : []; 

    $image = $_FILES['image'];
    $fileName = $_FILES['image']['name'];
    $fileTmp = $_FILES['image']['tmp_name'];

    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = uniqid('product_', true) . '.' . $fileExt;

    $file_path = $targePath . $newFileName;

    $images = $_FILES['images'] ?? null;

    $data = [
        'name' => $name,
        'ram' => $ram,
        'ssd' => $ssd,
        'hdd' => $hdd,
        'weight' => $weight,
        'screen' => $screen,
        'cpu' => $cpu,
        'quantity' => $quantity,
        'price' => $price,
        'description' => $description,
        'info' => $info,
        'isDiscount' => $isDiscount,
        'image' => $newFileName,
        'brandId' => $_POST['brand'],
        'typeId' => $_POST['type'],
        'percent' => $percent,
        'newPrice' => $newPrice,
        'sold' => 0
    ];

    $insertedId = $db->insertAndGetId('t_product', $data);
    if ($insertedId) {

        move_uploaded_file($fileTmp, $file_path);

        if ($images) {
            foreach ($images['tmp_name'] as $index => $tmpName) {
                if ($images['error'][$index] === UPLOAD_ERR_OK) {
                    $fileExtension = pathinfo($images['name'][$index], PATHINFO_EXTENSION);
                    $newFileNames =  'ProductSubImg_'. uniqid('image_', true) . '.' . $fileExtension; 
                    $filesPath = $targePath . $newFileNames;

                    $db->insert('t_product_image', ['image' => $newFileNames , 'productId' => $insertedId]);
                    move_uploaded_file($tmpName, $filesPath);
                }
            }
        }

        if($features){
            foreach ($features as $feature) {
                $db->insert('t_product_feature', ['productId' => $insertedId, 'featureId' => $feature]);
            }
        }

        if($specialTechnologies){
            foreach ($specialTechnologies as $specialTech) {
                $db->insert('t_product_special_tech', ['productId' => $insertedId, 'specialtechId' => $specialTech]);
            }
        }

        header("Location: ../index.php?page=add_product&type=success&message=Thêm thành công");
        exit();
    } else {
        header("Location: ../index.php?page=add_product&type=error&message=Thêm thất bại");
        exit();
    }
} else if (isset($_GET['action']) && $_GET['action'] === 'delete') {

    if ($db->delete('t_product', $_GET['id'])) {
        header("Location: ../index.php?page=list_product&type=success&message=Xóa thành công");
        exit();
    } else {
        header("Location: ../index.php?page=list_product&type=error&message=Xóa thất bại");
        exit();
    }
} else {
    header("Location: ../index.php");

    exit();
}