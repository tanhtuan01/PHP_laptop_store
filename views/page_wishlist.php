<div class="row">
    <h3>Danh sách sản phẩm đã lưu</h3>
</div>

<div class="products row">
    <?php if ($products): ?>
    <?php  foreach ($products as $product): ?>
    <!-- <a class="product" href="<?php echo $config['BASE_URL'] . '/views/product.php?id=' . $product['id'] ?>
"> -->
    <a class="product" href="#!">
        <?php if($product['isDiscount']) { ?>
        <div class="tag-discount">
            <div>
                Giảm giá <br> <?php echo $product['percent']; ?>%
            </div>
        </div>
        <?php } ?>
        <div class="box">
            <div class="image">
                <img src="https://cdn.tgdd.vn/Products/Images/44/311178/asus-vivobook-go-15-e1504fa-r5-nj776w-thumb-600x600.jpg"
                    alt="">
            </div>
            <div class="gift">
                <span>
                    Tặng Office
                </span>
            </div>
            <h3 class="name">
                <?php echo $product['name']; ?>
            </h3>
            <strong class="price">
                <?php echo (number_format($product['isDiscount'] ? $product['newPrice'] : $product['price'], 0, ',', '.')); ?>đ
            </strong>
            <?php if($product['isDiscount']) { ?>
            <div class="box-p">
                <p class="price-old"> <?php echo (number_format($product['price'], 0, ',', '.')) . "đ"; ?></p>
                <div class="percent"><b>-<?php echo $product['percent'] ?>%</b></div>
            </div>
            <?php } ?>
            <div class="add-to-cart">
                <div class="add-to-cart">
                    <button title="Xem sản phẩm" class="view" data-id="<?php echo $product['id']; ?>"
                        onclick="handleButtonViewClick(event)"><i class="fa-regular fa-eye"></i>&nbsp;</button>
                    <button type="button" title="Xóa khỏi yêu thích" class="view" style="background:silver"
                        data-id="<?php echo $product['wid']; ?>" onclick="handleButtonRemoveClick(event)">
                        ❌&nbsp;
                    </button>
                </div>
            </div>

        </div>
    </a>
    <?php  endforeach; ?>
    <?php else: ?>
    <p>Không có sản phẩm nào</p>
    <?php endif; ?>

</div>

<div class="row">
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
        <a class="page-item" href="?page=<?php echo ($currentPage - 1) ; ?>">« Trước</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>"
            class="<?php echo $i == $currentPage ? 'page-item active' : 'page-item'; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
        <?php if ($currentPage < $totalPages): ?>
        <a class="page-item" href="?page=<?php echo ($currentPage + 1) ; ?>">Sau »</a>
        <?php endif; ?>
    </div>
</div>

<script>
// 


function handleButtonRemoveClick(event) {
    event.stopPropagation();
    const button = event.target.closest('button');
    const wId = button.getAttribute('data-id');
    const baseUrl = window.location.origin + '/' + window.location.pathname.split('/')[1];
    const apiUrl = `${baseUrl}/rest/index.php?resource=wishlist&action=remove&id=${wId}`;
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            location.reload()
        })
}

function handleButtonViewClick(event) {
    event.stopPropagation();
    const button = event.target.closest('button');
    const productId = button.getAttribute('data-id');
    const baseUrl = window.location.origin + '/' + window.location.pathname.split('/')[1];
    window.location = `${baseUrl}/views/product.php?id=${productId}`;
}
</script>