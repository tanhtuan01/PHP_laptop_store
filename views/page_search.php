<div class="row">
    <h3><?php echo 'Kết quả tìm kiếm cho: "'. $q .'"'; ?></h3>
</div>

<div class="products row">
    <?php if ($products): ?>
    <?php  foreach ($products as $product): ?>
    <a class="product" href="<?php echo $config['BASE_URL'] . '/views/product.php?id=' . $product['id'] ?>
">
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
                <button title="Xem sản phẩm" class="view"><i class="fa-regular fa-eye"></i></i>&nbsp;</button>
                <button title="Thêm vào giỏ hàng" class="addtocart"><i
                        class="fa-solid fa-cart-arrow-down"></i>&nbsp;</button>
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
        <a class="page-item" href="?page=<?php echo ($currentPage - 1) .'&q=' .$q; ?>">« Trước</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i.'&q=' .$q; ?>"
            class="<?php echo $i == $currentPage ? 'page-item active' : 'page-item'; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
        <?php if ($currentPage < $totalPages): ?>
        <a class="page-item" href="?page=<?php echo ($currentPage + 1) .'&q=' .$q; ?>">Sau »</a>
        <?php endif; ?>
    </div>
</div>