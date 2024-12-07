<div class="product-filter">
    <button onclick="openFilterModal()"><i class="fa-solid fa-filter"></i>Lọc</button>
    <?php if($_SERVER["REQUEST_METHOD"] === "POST"){
?>
    <button
        onclick="window.location.href = window.location.origin + window.location.pathname.split('/').slice(0, -1).join('/') + '/';"
        class="reset" onclick="" title="Xóa bộ lọc"><i class="fa-solid fa-filter-circle-xmark"></i></button>

    <?php } ?>
</div>

<div class="row">
    <div id="filter-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeFilterModal()">&times;</span>
            <h3>Bộ lọc sản phẩm</h3>
            <br>
            <hr>
            <br>
            <div class="filter-row">
                <p class="filter-title">Hãng</p>
                <div class="f-brand">
                    <?php if($brands){
                        foreach($brands as $brand) {?>
                    <div class="f-b-brand">
                        <img data-id="<?php echo $brand['id']; ?>" title="<?php echo $brand['name']; ?>"
                            src="<?php echo $config['BRAND_IMAGE'] . $brand['image']; ?>" alt="Laptop Brand Image">
                    </div>
                    <?php } }  ?>
                </div>
            </div>
            <br>
            <hr>
            <div class="filter-row">
                <br>
                <div class="price-type-screen">
                    <div class="f-price">
                        <p class="filter-title">Giá</p>
                        <ul class="f-ul f-single-select">
                            <li data-price='between 0 and 10000000'>
                                Dưới 10 triệu
                            </li>
                            <li data-price='between 10000000 and 15000000'>
                                10 - 15 triệu
                            </li>
                            <li data-price='between 15000000 and 25000000'>
                                15 - 20 triệu
                            </li>
                        </ul>
                    </div>
                    <div class="f-type">
                        <p class="filter-title">Loại sản phẩm</p>
                        <ul class="f-ul f-single-select">
                            <?php if($types){
                                foreach($types as $type){?>
                            <li data-id="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></li>
                            <?php } } ?>
                        </ul>
                    </div>
                    <div class="f-screen">
                        <p class="filter-title">Kích cỡ màn hình</p>
                        <ul class="f-ul f-single-select">
                            <li data-value="13">Khoảng 13 inch</li>
                            <li data-value="14">Khoảng 14 inch</li>
                            <li data-value="15">Khoảng 15 inch</li>
                            <li data-value="16">Khoảng 16 inch</li>
                        </ul>
                    </div>
                </div>
            </div>
            <br>
            <hr>
            <br>
            <div class="filter-row">
                <div class="features-special-tech">
                    <div class="features">
                        <h3>Tính năng</h3>
                        <ul class="f-ul f-multi-select">
                            <?php if($features){
                                foreach($features as $feature){?>
                            <li data-id="<?php echo $feature['id']; ?>"><?php echo $feature['name']; ?></li>
                            <?php } } ?>
                        </ul>
                    </div>
                    <div class="special-tech">
                        <h3>Công nghệ đặc biệt</h3>
                        <ul class="f-ul f-multi-select">
                            <?php if($specialTechs){
                                foreach($specialTechs as $tech){?>
                            <li data-id="<?php echo $type['id']; ?>"><?php echo $tech['name']; ?></li>
                            <?php } } ?>
                        </ul>
                    </div>
                    <div class="ram">
                        <h3>RAM</h3>
                        <ul class="f-ul f-single-select">
                            <li data-value="4">4 GB</li>
                            <li data-value="8">8 GB</li>
                            <li data-value="16">16 GB</li>
                            <li data-value="18">18 GB</li>
                            <li data-value="24">24 GB</li>
                            <li data-value="32">32 GB</li>
                            <li data-value="36">36 GB</li>
                            <li data-value="48">48 GB</li>
                            <li data-value="64">64 GB</li>
                            <li data-value="128">128 GB</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="filter-row">
                <div class="btn-apply">
                    <button class="apply-filter-btn btn-apply">Áp dụng</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form ẩn -->
<form id="filter-form" action="<?php echo $config['BASE_URL'] . '/index.php#filtered'?>" method="POST"
    style="display: none;">
    <input type="hidden" name="brand" id="form-brand">
    <input type="hidden" name="price" id="form-price">
    <input type="hidden" name="type" id="form-type">
    <input type="hidden" name="screen" id="form-screen">
    <input type="hidden" name="features" id="form-features">
    <input type="hidden" name="specialTech" id="form-specialTech">
    <input type="hidden" name="ram" id="form-ram">
</form>


<script>
document.addEventListener("DOMContentLoaded", () => {
    const selectedFilters = {
        brand: null,
        price: null,
        type: null,
        screen: null,
        features: [],
        specialTech: [],
        ram: null,
    };

    function handleSingleSelect(parentSelector, key) {
        const items = document.querySelectorAll(`${parentSelector} .f-ul li`);
        items.forEach((item) => {
            item.addEventListener("click", () => {
                if (item.classList.contains("active")) {
                    item.classList.remove("active");
                    selectedFilters[key] = null;
                } else {
                    items.forEach((el) => el.classList.remove("active"));
                    item.classList.add("active");
                    selectedFilters[key] = item.dataset.id || item.dataset.value || item.dataset
                        .price;
                }
                console.log(`Selected ${key}:`, selectedFilters[key]);
            });
        });
    }

    function handleMultiSelect(parentSelector, key) {
        const items = document.querySelectorAll(`${parentSelector} .f-ul li`);
        items.forEach((item) => {
            item.addEventListener("click", () => {
                const value = item.dataset.id || item.dataset.value;
                if (item.classList.contains("active")) {
                    item.classList.remove("active");
                    selectedFilters[key] = selectedFilters[key].filter((v) => v !== value);
                } else {
                    item.classList.add("active");
                    selectedFilters[key].push(value);
                }
                console.log(`Selected ${key}:`, selectedFilters[key]);
            });
        });
    }

    function handleSingleSelectDiv(parentSelector, key) {
        const items = document.querySelectorAll(`${parentSelector} .f-b-brand`);
        items.forEach((item) => {
            item.addEventListener("click", () => {
                if (item.classList.contains("selected")) {
                    item.classList.remove("selected");
                    selectedFilters[key] = null;
                    console.log(`Deselected ${key}:`, selectedFilters[key]);
                } else {
                    items.forEach((el) => el.classList.remove("selected"));
                    item.classList.add("selected");
                    selectedFilters[key] = item.querySelector('img').dataset.id;
                    console.log(`Selected ${key}:`, selectedFilters[key]);
                }
            });
        });
    }

    // Áp dụng các xử lý
    handleSingleSelectDiv(".f-brand", "brand");
    handleSingleSelect(".f-price", "price");
    handleSingleSelect(".f-type", "type");
    handleSingleSelect(".f-screen", "screen");
    handleMultiSelect(".features", "features");
    handleMultiSelect(".special-tech", "specialTech");
    handleSingleSelect(".ram", "ram");

    document.querySelector(".btn-apply").addEventListener("click", () => {
        const form = document.getElementById("filter-form");
        document.getElementById("form-brand").value = selectedFilters.brand || '';
        document.getElementById("form-price").value = selectedFilters.price || '';
        document.getElementById("form-type").value = selectedFilters.type || '';
        document.getElementById("form-screen").value = selectedFilters.screen || '';
        document.getElementById("form-features").value = selectedFilters.features.join(",") || '';
        document.getElementById("form-specialTech").value = selectedFilters.specialTech.join(",") || '';
        document.getElementById("form-ram").value = selectedFilters.ram || '';

        form.submit();
    });

});


const filterModal = document.getElementById('filter-modal');

function openFilterModal() {
    filterModal.style.display = 'block'
}

function closeFilterModal() {
    filterModal.style.display = 'none'
}
</script>