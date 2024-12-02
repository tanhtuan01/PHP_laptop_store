<?php 
require_once dirname(dirname(__DIR__)) . '/db/base.php';

$db = new Database();
$targePath = dirname(dirname(__DIR__)) . '/assets/images/brands/';

if ($_POST && isset($_POST['submit'])) {
    $id = $_POST['id'];
    $data = [
        'shortName' => $_POST['shortName'],
        'name' => $_POST['name']
    ];

    if ($_FILES['image']['name']) {
        $imageExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newImageName = uniqid('brand_', true) . '.' . $imageExtension;
        $data['image'] = $newImageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targePath . $newImageName);
    }

    $resultType = $db->update('t_brand', $data, ['id' => $id]) ? 'success' : 'error';
    $resultMessage = $resultType === 'success' ? 'Cập nhật thành công' : 'Cập nhật thất bại';
    header("Location: ../index.php?page=brand&type=$resultType&message=$resultMessage");
}
?>