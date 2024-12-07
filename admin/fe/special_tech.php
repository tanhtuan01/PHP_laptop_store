<?php 
require_once dirname(dirname(__DIR__)) . '/db/base.php';

$db = new Database();
$specialsTech = $db->findAll('t_special_tech',[],'id','DESC'); 
?>

<div id="type">
    <h2>Thêm Công Nghệ Mới </h2>
    <form action="be/special_tech.php" method="POST">
        <div class="spec-group">
            <label for="name">Tên Loại:</label>
            <input type="text" id="name" name="name" placeholder="Nhập tên loại sản phẩm">
        </div>
        <div class="spec-group">
            <label for="desc">Mô tả:</label>
            <textarea style="width: 100%;padding: 5px;resize:none;border-radius:5px" type="text" id="desc" name="desc"
                placeholder="Nhập mô tả loại công nghệ" rows="3"></textarea>
        </div>
        <br>
        <div>
            <button type="submit" name="submit">Thêm Mới</button>
        </div>
    </form>

    <?php if (isset($_GET['message'])): ?>
    <div class="alert alert-<?php echo htmlspecialchars($_GET['type']); ?>">
        <span class="alert-icon">✔️</span>
        <?php echo htmlspecialchars($_GET['message']); ?>
    </div>
    <?php endif; ?>

    <h2>Danh Sách Công Nghệ Đặc Biệt</h2>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên Loại</th>
                <th>Mô tả</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($specialsTech)): ?>
            <?php $i = 1; foreach ($specialsTech as $type): ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo htmlspecialchars($type['name']); ?></td>
                <td><?php echo htmlspecialchars($type['description']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $type['id']; ?>">Sửa</a>
                    <a href="be/special_tech.php?action=delete&id=<?php echo $type['id']; ?>"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa tên loại công nghệ này không?');">Xóa</a>
                </td>
            </tr>
            <?php $i++; endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="4">Danh sách trống.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>