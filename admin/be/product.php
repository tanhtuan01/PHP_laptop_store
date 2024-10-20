<?php 

	require dirname(dirname(__DIR__)) . '/db/connect.php';

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

    $FILE = $_FILES['image'];
    $fileName = $_FILES['image']['name'];	
    $fileTmp = $_FILES['image']['tmp_name'];

    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION); 
    $newFileName = uniqid('product_', true) . '.' . $fileExt; 

    $file_path = $targePath . $newFileName;

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
    ];

    if ($db->insert('t_product', $data)) {
     
    move_uploaded_file($fileTmp, $file_path);
   header("Location: ../index.php?page=add_product&type=success&message=Thêm thành công"); 
    exit(); 
    }else{
        header("Location: ../index.php?page=add_product&type=error&message=Thêm thất bại"); 
    exit(); 
    }

	} 
    else if(isset($_GET['action']) && $_GET['action'] === 'delete'){

         if($db->delete('t_product',$_GET['id'])){
             header("Location: ../index.php?page=list_product&type=success&message=Xóa thành công");
        exit();
         }else{
            header("Location: ../index.php?page=list_product&type=error&message=Xóa thất bại");
        exit();
         }
    }

    else {
        header("Location: ../index.php"); 

	    exit(); 
	}
?>