<?php 
require_once dirname(dirname(__DIR__)) . '/db/base.php';

$db = new Database();

$brands = $db->findAll('t_brand');
$type = $db->findAll('t_type');

$product = $db->getOne('t_product', $id); 

?>

<div id="addProduct">
    <h2>Sửa Sản Phẩm</h2>
    <form method="POST" action="be/edit_product.php" enctype="multipart/form-data">

        <input type='hidden' name='id' value="<?php echo $product['id']; ?>">
        <div class="specifications">
            <div class="spec-group">
                <label for="brand">Hãng laptop:</label>
                <select name="brand">
                    <?php if (!empty($brands)): ?>
                    <?php foreach ($brands as $brand): ?>
                    <option value="<?php echo htmlspecialchars($brand['id']); ?>">
                        <?php echo htmlspecialchars($brand['name']); ?>
                    </option>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <option value="" disabled>Không có thương hiệu nào.</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="spec-group">
                <label for="type">Loại laptop</label>
                <select name="type">
                    <?php if (!empty($type)): ?>
                    <?php foreach ($type as $t): ?>
                    <option value="<?php echo htmlspecialchars($t['id']); ?>">
                        <?php echo htmlspecialchars($t['name']); ?>
                    </option>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <option value="" disabled>Không có loại nào.</option>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <label for="name">Tên Sản Phẩm:</label>
        <input type="text" id="name" name="name" require_onced value="<?php echo $product['name']; ?>">

        <div class="specifications">
            <div class="spec-group">
                <label for="ram">RAM (GB):</label>
                <input type="number" id="ram" name="ram" onkeydown="inputOnlyNumber(event)" require_onced
                    value="<?php echo $product['ram']; ?>">
            </div>
            <div class="spec-group">
                <label for="ssd">SSD:</label>
                <input type="text" id="ssd" name="ssd" placeholder="GB, TB" require_onced
                    value="<?php echo $product['ssd']; ?>">
            </div>
            <div class="spec-group">
                <label for="hdd">HDD:</label>
                <input type="text" id="hdd" name="hdd" placeholder="GB, TB" require_onced
                    value="<?php echo $product['hdd']; ?>">
            </div>
            <div class="spec-group">
                <label for="weight">Trọng Lượng (kg):</label>
                <input type="number" id="weight" name="weight" step="0.01" require_onced
                    value="<?php echo $product['weight']; ?>" onkeydown="inputDotAndNumber(event)">
            </div>
        </div>

        <div class="specifications">
            <div class="spec-group">
                <label for="screen">Kích Thước Màn Hình (inch):</label>
                <input type="number" id="screen" name="screen" step="0.1" require_onced
                    value="<?php echo $product['screen']; ?>" onkeydown="inputDotAndNumber(event)">
            </div>
            <div class="spec-group">
                <label for="cpu">CPU:</label>
                <input type="text" id="cpu" name="cpu" require_onced value="<?php echo $product['cpu']; ?>">
            </div>
        </div>

        <div class="specifications">
            <div class="spec-group">
                <label for="quantity">Số lượng:</label>
                <input type="number" id="quantity" name="quantity" require_onced
                    value="<?php echo $product['quantity']; ?>" onkeydown="inputOnlyNumber(event)">
            </div>
            <div class="spec-group">
                <label for="price">Giá:</label>
                <input type="number" id="price" name="price" onkeydown="inputOnlyNumber(event)" require_onced
                    value="<?php echo $product['price']; ?>">
            </div>
        </div>

        <label for="image">Hình Ảnh</label>
        <input type="file" id="image" name="image" accept="image/*">

        <label for="description">Mô Tả:</label>
        <textarea id="description" name="description" rows="4"
            require_onced><?php echo $product['description']; ?></textarea>

        <label for="info">Thông Tin Khác:</label>
        <textarea id="info" name="info" rows="4"><?php echo $product['info']; ?></textarea>

        <!-- <div class="discount-checkbox">
            <input type="checkbox" id="isDiscount" name="isDiscount"
                value="<?php echo $product['isDiscount'] ? 'checked' : ''; ?>">
            <label for="isDiscount">Sản Phẩm Giảm Giá</label>
        </div> -->

        <div class="discount-checkbox">
            <input type="checkbox" id="isDiscount" name="isDiscount" value="1"
                <?php echo (!empty($product['isDiscount']) && $product['isDiscount'] == "1") ? 'checked' : ''; ?>>
            <label for="isDiscount">Sản Phẩm Giảm Giá</label>
        </div>


        <div id="discountFields" style="display: none;">
            <div style="display: flex;justify-content:center">
                <div style="margin-right:10px">
                    <label for="discountPercent">Tỷ Lệ Giảm Giá (%)</label>
                    <input type="number" id="discountPercent" name="discountPercent" step="1" min="0" max="100"
                        onkeydown="inputOnlyNumber(event)" value="<?php echo $product['percent']; ?>">
                </div>
                <div>
                    <label for="newPrice">Giá Sau Giảm Giá</label>
                    <input type="number" id="newPrice" name="newPrice" readonly
                        value="<?php echo $product['newPrice']; ?>">
                </div>
            </div>
        </div>

        <input type="submit" name="submit" value="Cập nhật Sản Phẩm">
    </form>
</div>

<script>
let isDiscount = document.getElementById('isDiscount').checked

if (isDiscount) {
    discountFields.style.display = 'block';
    calculateDiscountedPrice();
}

document.getElementById('isDiscount').addEventListener('change', function() {
    var discountFields = document.getElementById('discountFields');
    if (this.checked) {
        discountFields.style.display = 'block';
        calculateDiscountedPrice();
    } else {
        discountFields.style.display = 'none';
        document.getElementById('discountPercent').value = '';
        document.getElementById('newPrice').value = '';
    }
});

document.getElementById('discountPercent').addEventListener('input', function() {
    calculateDiscountedPrice();
});

document.getElementById('price').addEventListener('input', function() {
    calculateDiscountedPrice();
})

function calculateDiscountedPrice() {
    var price = parseFloat(document.getElementById('price').value) || 0;
    var discountPercent = parseFloat(document.getElementById('discountPercent').value) || 0;
    var newPriceField = document.getElementById('newPrice');

    if (price > 0 && discountPercent > 0) {
        var newPrice = price * (1 - discountPercent / 100);
        newPriceField.value = Math.round(newPrice.toFixed(2))
    } else {
        newPriceField.value = Math.round(newPrice.toFixed(2))
    }
}
</script>