<?php
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$sort = isset($_GET['sort']) && in_array(strtoupper($_GET['sort']), ['ASC', 'DESC']) ? strtoupper($_GET['sort']) : 'DESC';
$conditions = [
    'isDiscount' => false,
];

$from = isset($_GET['from']) ? (int)$_GET['from'] : null;
$to = isset($_GET['to']) ? (int)$_GET['to'] : null;

if ($from !== null && $to !== null && $from <= $to) {
    $conditions['price BETWEEN ? AND ?'] = [$from, $to];
    $paginationData = $productDb->productFilterPagination(
        't_product',
        $conditions,
        'price',
        $sort,
        $config['DEFAULT_PAGE_SIZE'],
        $page
    );
}else{
    $paginationData = $db->findWithPagination(
        't_product',
        $conditions,
        null,
        null,
        'price',
        $sort,   
        $config['DEFAULT_PAGE_SIZE'],
        $page
    );
}



$products = $paginationData['data'];
$totalPages = $paginationData['last_page'];
$currentPage = $paginationData['current_page'];
?>


<div class="row">
    <div class="title-more">
        <h3 class="title-block">Một số sản phẩm</h3>
    </div>
</div>

<div class="row sort">
    Sắp xếp theo: <ul>

        <li>
            <a href="?sort=asc">Giá tăng dần</a>
        </li>
        <li>
            <a href="?sort=desc">Giá giảm dần</a>
        </li>

    </ul>
    | &nbsp;
    <form action="" method="GET">
        Từ <input type="number" placeholder="Từ" name="from" id="" required>
        Đến <input type="number" placeholder="Từ" name="to" id="" required>
        <input type="submit" name="" id="" value="Tìm">
    </form>
</div>

<div class="products row">
    <?php if ($products): ?>
    <?php 
        foreach ($products as $product): ?>
    <a class="product" href="<?php echo $config['BASE_URL'] . '/views/product.php?id=' . $product['id'] ?>
">
        <div class="box">
            <div class="image">
                <img src="<?php echo $config['BASE_URL'] . '/assets/images/products/' . $product['image']; ?>" alt="">
            </div>
            <div class="gift">
                <span>
                    Tặng Office
                </span>
            </div>
            <h3 class="name">
                <?php echo $product['name']; ?>
            </h3>
            <div class="hardware">
                <span class="tag">RAM<?php echo $product['ram']; ?>GB</span>
                <span class="tag">SSD<?php echo $product['ssd']; ?>GB</span>
            </div>
            <strong class="price">
                <?php echo (number_format($product['price'], 0, ',', '.')) . "đ"; ?>
            </strong>
            <div class="add-to-cart">
                <button title="Xem sản phẩm" class="view"><i class="fa-regular fa-eye"></i></i>&nbsp;</button>
                <button title="Thêm vào giỏ hàng" class="addtocart"><i
                        class="fa-solid fa-cart-arrow-down"></i>&nbsp;</button>
            </div>
        </div>
    </a>
    <?php 
        endforeach; ?>
    <?php else: ?>
    <p>Không có sản phẩm nào</p>
    <?php endif; ?>

</div>

<div class="row">
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
        <a class="page-item" href="?page=<?php echo $currentPage - 1; ?>">« Trước</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>"
            class="<?php echo $i == $currentPage ? 'page-item active' : 'page-item'; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
        <?php if ($currentPage < $totalPages): ?>
        <a class="page-item" href="?page=<?php echo $currentPage + 1; ?>">Sau »</a>
        <?php endif; ?>
    </div>
</div>