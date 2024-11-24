<?php
require_once dirname(dirname(__DIR__)) . '/db/connect.php';

$db = new Database();

$products = $db->findAll('t_product', [], 'id', 'DESC');

$productImagePath = '/TMPWEB/assets/images/products/';
?>

<h3>Danh Sách Sản Phẩm</h3>

<div id="listProduct">
    <table>
        <thead>
            <tr>
                <th style="width: 30px;text-align:center">STT</th>
                <th style="width: 50px;text-align:center">Ảnh</th>
                <th>Tên Sản Phẩm</th>
                <th style="width: 80px;text-align:center">Số lượng</th>
                <th style="width: 150px;text-align:center">Giá bán</th>
                <th style="width: 80px;text-align:center">Giảm giá</th>
                <th style="width: 100px;text-align:center">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($products): ?>
                <?php $i = 1;
                foreach ($products as $product): ?>
                    <tr>
                        <td style="width: 30px;text-align:center"><?php echo $i; ?></td>
                        <td style=" width: 50px;">
                            <img style="width: 50px; height: 30px; margin: auto;"
                                src="<?php echo ($productImagePath . $product['image']); ?>"
                                alt="<?php echo ($product['name']); ?>">
                        </td>
                        </td>
                        <td><?php echo ($product['name']); ?></td>
                        <td style="width: 80px;text-align:center"><?php echo ($product['quantity']); ?></td>
                        <td style="width: 150px;text-align:center">
                            <?php echo (number_format($product['price'], 0, ',', '.')); ?>
                            VNĐ</td>
                        <td style="width: 80px;text-align:center"><?php echo ($product['isDiscount']) ? 'Có' : 'Không'; ?></td>
                        <td style="width: 100px;text-align:center">
                            <!-- <a href="./index.php?page=edit_product&id=<?php echo $product['id']; ?>">Sửa</a> |  -->
                            <a href="javascript:void(0);"
                                onclick="loadContent('edit_product.php', <?php echo $product['id']; ?>);">Sửa</a>

                            <a href="be/product.php?action=delete&id=<?php echo $product['id']; ?>"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                        </td>
                    </tr>
                <?php $i++;
                endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Không có sản phẩm nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>