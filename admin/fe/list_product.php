<?php 
    require dirname(dirname(__DIR__)) . '/db/connect.php';

    $db = new Database();

    $products = $db->findAll('t_product', [], 'id','DESC');

    $productImagePath = '/TMPWEB/assets/images/products/';
?>



 <h1>Danh Sách Sản Phẩm</h1>

   <div id="listProduct">
        <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Ảnh</th>
                <th>Tên Sản Phẩm</th>
                <th>Giá</th>
                <th>Giảm giá</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($products): ?>
                <?php $i = 1; foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td style="width: 50px;">
                             <img style="width: 50px; height: 30px; margin: auto;" 
                                 src="<?php echo ($productImagePath . $product['image']); ?>" 
                                 alt="<?php echo ($product['name']); ?>">
                        </td> 
                        </td>
                        <td><?php echo ($product['name']); ?></td>
                        <td><?php echo (number_format($product['price'], 0, ',', '.')); ?> VNĐ</td>
                        <td><?php echo ($product['isDiscount']) ? 'Có' : 'Không'; ?></td>
                        <td>
                            <a href="./index.php?page=edit_product&id=<?php echo $product['id']; ?>">Sửa</a> | 
                            <a href="be/product.php?action=delete&id=<?php echo $product['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                        </td>
                    </tr>
                <?php $i++; endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Không có sản phẩm nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
   </div>