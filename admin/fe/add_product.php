
<?php 
    require_once dirname(dirname(__DIR__)) . '/db/connect.php';

    $db = new Database();

    $brands = $db->findAll('t_brand');

    $type =  $db->findAll('t_type');
?>

<div id="addProduct">
    <h2>Thêm Sản Phẩm</h2>
    <form method="POST" action="be/product.php" enctype="multipart/form-data">

        <div class="specifications">
            <div class="spec-group">
                <label for="brand">Hãng laptop:</label>
      <select  name="brand">
        <?php if (!empty($brands)): ?>
            <?php foreach ($brands as $brand): ?>
                <option value="<?php echo htmlspecialchars($brand['id']); ?>">
                    <?php echo htmlspecialchars($brand['name']); ?>
                </option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value=""disabled>Không có thương hiệu nào.</option>
        <?php endif; ?>
    </select>
            </div>

            <div class="spec-group">
                <label for="type">Loại laptop</label>
      <select  name="type">
        <?php if (!empty($type)): ?>
            <?php foreach ($type as $t): ?>
                <option value="<?php echo htmlspecialchars($t['id']); ?>">
                    <?php echo htmlspecialchars($t['name']); ?>
                </option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value=""disabled>Không có loại nào.</option>
        <?php endif; ?>
    </select>
            </div>
        </div>

        <label for="name">Tên Sản Phẩm:</label>
        <input type="text" id="name" name="name" require_onced>

        <div class="specifications">
            <div class="spec-group">
                <label for="ram">RAM (GB):</label>
                <input type="number" id="ram" name="ram" require_onced>
            </div>
            <div class="spec-group">
                <label for="ssd">SSD (GB):</label>
                <input type="number" id="ssd" name="ssd" require_onced>
            </div>
            <div class="spec-group">
                <label for="hdd">HDD (GB):</label>
                <input type="number" id="hdd" name="hdd" require_onced>
            </div>
            <div class="spec-group">
                <label for="weight">Trọng Lượng (kg):</label>
        <input type="number" id="weight" name="weight" step="0.01" require_onced>
            </div>
        </div>


         <div class="specifications">
             <div class="spec-group">
                 <label for="screen">Kích Thước Màn Hình (inch):</label>
        <input type="number" id="screen" name="screen" step="0.1" require_onced>
             </div>
             <div class="spec-group">
                 <label for="cpu">CPU:</label>
        <input type="text" id="cpu" name="cpu" require_onced>
             </div>
         </div>

        

        

        <div class="specifications">
            <div class="spec-group">
                <label for="quantity">Số lượng:</label>
        <input type="number" id="quantity" name="quantity" require_onced>

 
            </div>
            <div class="spec-group">
                       <label for="price">Giá:</label>
        <input type="number" id="price" name="price" require_onced>
            </div>
        </div>

        <label for="image">Hình Ảnh:</label>
        <input type="file" id="image" name="image" accept="image/*" require_onced>

        <label for="description">Mô Tả:</label>
        <textarea id="description" name="description" rows="4" require_onced></textarea>

        <label for="info">Thông Tin Khác:</label>
        <textarea id="info" name="info" rows="4"></textarea>

        <div class="discount-checkbox">
            <input type="checkbox" id="isDiscount" name="isDiscount">
            <label for="isDiscount">Sản Phẩm Giảm Giá</label>
        </div>

        <input type="submit" name="submit" value="Thêm Sản Phẩm">
    </form>
</div>
