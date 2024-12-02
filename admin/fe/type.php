<?php 
require_once dirname(dirname(__DIR__)) . '/db/base.php';

$db = new Database();
$types = $db->findAll('t_type',[],'id','DESC'); 
?>

<div id="type">
    <h2>Thêm Loại Sản Phẩm Mới</h2>
    <form action="be/type.php" method="POST">
        <div class="spec-group">
            <label for="name">Tên Loại:</label>
            <input type="text" id="name" name="name" require_onced placeholder="Nhập tên loại sản phẩm">
        </div>
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

    <h2>Danh Sách Loại Sản Phẩm</h2>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên Loại</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($types)): ?>
                <?php $i = 1; foreach ($types as $type): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($type['name']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $type['id']; ?>">Sửa</a>
                            <a href="be/type.php?action=delete&id=<?php echo $type['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa loại sản phẩm này không?');">Xóa</a>
                        </td>
                    </tr>
                    <?php $i++; endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Không có loại sản phẩm nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>