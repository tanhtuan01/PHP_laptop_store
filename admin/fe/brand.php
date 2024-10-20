<?php 
require dirname(dirname(__DIR__)) . '/db/connect.php';

$db = new Database();


$brands = $db->findAll('t_brand'); 
?>

 <div id="brand">
        <h2>Thêm Thương Hiệu Mới</h2>
        <form action="be/brand.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="shortName">Tên Ngắn:</label>
                <input type="text" id="shortName" name="shortName" required placeholder="eg: dell, hp,...">
            </div>
            <div>
                <label for="name">Tên Thương Hiệu:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="image">Ảnh Thương Hiệu:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <div>
                <button type="submit" name="submit">Thêm Mới</button>
            </div>
        </form>



        <h2>Danh Sách Thương Hiệu</h2>
        <table>
            <thead>
                <tr>
<th>STT</th>
                    <th>Ảnh</th>
                    <th>Tên Ngắn</th>
                    <th>Tên Thương Hiệu</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
        <?php if (!empty($brands)): ?>
            <?php $i = 1; foreach ($brands as $brand): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>
                        <?php if ($brand['image']): ?>
                            <img src="<?php echo htmlspecialchars($brand['image']); ?>" alt="<?php echo htmlspecialchars($brand['name']); ?>" style="width: 50px; height: auto;">
                        <?php else: ?>
                            Không có ảnh
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($brand['shortName']); ?></td>
                    <td><?php echo htmlspecialchars($brand['name']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $brand['id']; ?>">Sửa</a>
                        <a href="be/brand.php?action=delete&id=<?php echo $brand['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa thương hiệu này không?');">Xóa</a>
                    </td>
                </tr>
                <?php $i++; endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Không có thương hiệu nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
        </table>
    </div>

