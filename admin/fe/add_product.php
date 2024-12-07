<?php
require_once dirname(dirname(__DIR__)) . '/db/base.php';

$db = new Database();

$brands = $db->findAll('t_brand');

$type =  $db->findAll('t_type');

$features =  $db->findAll('t_features');

$specialTechs =  $db->findAll('t_special_tech');
?>

<div id="addProduct">
    <h2>Thêm Sản Phẩm</h2>
    <form method="POST" action="be/product.php" enctype="multipart/form-data">

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

        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" required>

        <div class="specifications">
            <div class="spec-group">
                <label for="ram">RAM (GB):</label>
                <input type="number" id="ram" name="ram" required onkeydown="inputOnlyNumber(event)">
            </div>
            <div class="spec-group">
                <label for="ssd">SSD:</label>
                <input type="text" id="ssd" name="ssd" required placeholder="GB, TB">
            </div>
            <div class="spec-group">
                <label for="hdd">HDD:</label>
                <input type="text" id="hdd" name="hdd" required placeholder="GB, TB">
            </div>
            <div class="spec-group">
                <label for="weight">Trọng lượng (kg):</label>
                <input type="number" id="weight" name="weight" step="0.01" required
                    onkeydown="inputDotAndNumber(event)">
            </div>
        </div>

        <div class="specifications">
            <div class="spec-group">
                <label for="screen">Kích thước màn hình (inch):</label>
                <input type="number" id="screen" name="screen" step="0.1" required onkeydown="inputDotAndNumber(event)">
            </div>
            <div class="spec-group">
                <label for="cpu">CPU:</label>
                <input type="text" id="cpu" name="cpu" required>
            </div>
        </div>

        <div class="specifications">
            <div class="spec-group">
                <label for="quantity">Số lượng:</label>
                <input type="number" id="quantity" name="quantity" required onkeydown="inputOnlyNumber(event)">
            </div>
            <div class="spec-group">
                <label for="price">Giá:</label>
                <input type="number" id="price" name="price" required onkeydown="inputOnlyNumber(event)">
            </div>
        </div>

        <div>
            <img id="previewImage" style="display: block;margin: auto;border:1px solid silver" src="" width="300"
                height="200" alt="">
        </div>
        <label for="image">Hình Ảnh:</label>
        <input type="file" id="image" name="image" accept="image/*" required>

        <label for="description">Mô Tả:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <label for="info">Thông Tin Khác:</label>
        <textarea id="info" name="info" rows="4"></textarea>

        <div class="discount-checkbox">
            <input type="checkbox" id="isDiscount" name="isDiscount" onkeydown="inputOnlyNumber(event)">
            <label for="isDiscount">Giảm Giá</label>
        </div>

        <div id="discountFields" style="display: none;">
            <div style="display: flex;justify-content:center">
                <div style="margin-right:10px">
                    <label for="discountPercent">Tỷ Lệ Giảm Giá (%)</label>
                    <input type="number" id="discountPercent" name="discountPercent" step="1" min="0" max="100"
                        onkeydown="inputOnlyNumber(event)">
                </div>
                <div>
                    <label for="newPrice">Giá Sau Giảm Giá</label>
                    <input type="number" id="newPrice" name="newPrice" readonly>
                </div>
            </div>
        </div>

        <div class="specifications">
            <label for="features">Tính năng</label>
            <div id="features" class="features-checkbox-group">
                <?php 
                if($features){
                    foreach($features as $feature){ 
                ?>
                <label>
                    <input type="checkbox" name="features[]" value="<?php echo $feature['id']; ?>">
                    <?php echo $feature['name']; ?>
                </label>
                <?php  }} ?>
            </div>
        </div>

        <div class="specifications">
            <label for="specialTechnologies">Công nghệ đặc biệt</label>
            <div id="specialTechnologies" class="features-checkbox-group">
                <?php 
                if($specialTechs){
                    foreach($specialTechs as $specialTech){ 
                ?>
                <label>
                    <input type="checkbox" name="specialTechnologies[]" value="<?php echo $specialTech['id']; ?>">
                    <?php echo $specialTech['name']; ?>
                </label>
                <?php  }} ?>
            </div>
        </div>


        <div>
            <label for="images">Một số hình ảnh khác (Nếu có):</label>
            <input type="file" id="images" name="images[]" accept="image/*" multiple>
            <div id="imagePreviewContainer"></div>
            <div id="hiddenInputsContainer"></div>
        </div>


        <input type="submit" name="submit" value="Thêm Sản Phẩm">
    </form>
</div>

<script>
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
});

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


<script>
document.getElementById('image').addEventListener('change', function(event) {
    var fileInput = event.target;
    var file = fileInput.files[0];
    var previewImage = document.getElementById('previewImage');

    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        previewImage.src = '';
    }
});
</script>

<!-- Multiple Image -->
<script>
document.getElementById('images').addEventListener('change', function(event) {
    const files = Array.from(event.target.files);
    const previewContainer = document.getElementById('imagePreviewContainer');
    const hiddenInputsContainer = document.getElementById('hiddenInputsContainer');

    previewContainer.innerHTML = '';
    hiddenInputsContainer.innerHTML = '';

    files.forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'image-preview';

            const img = document.createElement('img');
            img.src = e.target.result;

            const removeBtn = document.createElement('button');
            removeBtn.innerText = '×';
            removeBtn.className = 'remove-btn';

            removeBtn.onclick = function() {
                files.splice(index, 1);
                div.remove();

                updateFileInput(files);
            };

            div.appendChild(img);
            div.appendChild(removeBtn);
            previewContainer.appendChild(div);
        };

        reader.readAsDataURL(file);
    });

    function updateFileInput(updatedFiles) {
        const dataTransfer = new DataTransfer();
        updatedFiles.forEach(file => dataTransfer.items.add(file));
        document.getElementById('images').files = dataTransfer.files;
    }
});
</script>