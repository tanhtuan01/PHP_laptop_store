<?php 

	require_once dirname(dirname(__DIR__)) . '/db/connect.php';

    $targePath = dirname(dirname(__DIR__)) . '/assets/images/brands/';

	$db = new Database();

	if ($_POST && isset($_POST['submit'])) {
    $shortName = $_POST['shortName'];
    $name = $_POST['name'];
    
	$image = null;
	    $imageName = basename($_FILES['image']['name']);
	    
	    $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
	    $newImageName = uniqid('brand_', true) . '.' . $imageExtension; // Tạo tên file duy nhất
	    $targetFilePath = $targePath . $newImageName;

	  move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath);

        $data = [
            'shortName' => $shortName,
            'name' => $name,
            'image' => $newImageName
        ];

        if ($db->insert('t_brand', $data)) {
           header("Location: ../index.php?page=brand&type=success&message=Thêm thành công");
        } else {
           header("Location: ../index.php?page=brand&type=error&message=Thêm thất bại");
        }

         
exit();
}

// Handle delete
if(isset($_GET['action']) && $_GET['action'] === 'delete'){

 if($db->delete('t_brand',$_GET['id'])){
	 header("Location: ../index.php?page=brand&type=success&message=Xóa thành công");
exit();
 }else{
 	header("Location: ../index.php?page=brand&type=error&message=Xóa thất bại");
exit();
 }
}


?>