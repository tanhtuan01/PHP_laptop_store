<?php 
    require_once dirname(dirname(__DIR__)) . '/db/connect.php';

    $db = new Database();

    $config = require_once dirname(dirname(__DIR__)) . '/config/config.php';

    $brand = $db->getOne('t_brand', $id); 
?>

<div id="brand">
    <h2>Cập nhật Thương Hiệu</h2>
    <form action="be/edit_brand.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?php echo $brand['id']; ?>">
        <div>
            <label for="shortName">Tên Ngắn:</label>
            <input type="text" id="shortName" name="shortName" value="<?php echo $brand['shortName']; ?>" require_onced
                placeholder="eg: dell, hp,...">
        </div>
        <div>
            <label for="name">Tên Thương Hiệu:</label>
            <input type="text" id="name" name="name" require_onced value="<?php echo $brand['name']; ?>">
        </div>
        <div>
            <label for="image">Ảnh Thương Hiệu:</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>
        <div>
            <button type="submit" name="submit">Cập nhật</button>
        </div>
    </form>

</div>