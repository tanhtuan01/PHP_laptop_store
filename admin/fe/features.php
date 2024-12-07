<?php 
require_once dirname(dirname(__DIR__)) . '/db/base.php';

$db = new Database();
$features = $db->findAll('t_features',[],'id','DESC'); 
?>

<div id="type">
    <h2>Thêm Tính Năng Mới</h2>
    <form action="be/features.php" method="POST">
        <div class="spec-group">
            <label for="name">Tên:</label>
            <input type="text" id="name" name="name" required placeholder="Nhập tên tính năng của laptop">
        </div>
        <div class="spec-group">
            <label for="desc">Mô tả:</label>
            <textarea required style="width: 100%;padding: 5px;resize:none;border-radius:5px" type="text" id="desc"
                name="desc" placeholder="Nhập mô tả tính năng" rows="3"></textarea>
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

    <h2>Danh Sách Tính Năng</h2>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên</th>
                <th>Mô tả</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($features)): ?>
            <?php $i = 1; foreach ($features as $type): ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo htmlspecialchars($type['name']); ?></td>
                <td><?php echo htmlspecialchars($type['description']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $type['id']; ?>">Sửa</a>
                    <a href="be/features.php?action=delete&id=<?php echo $type['id']; ?>"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa tên tính năng này không?');">Xóa</a>
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