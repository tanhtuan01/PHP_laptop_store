<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'add_product.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : "";
$allowed_pages = [
	'add_product.php',
	'list_product.php',
	'discounted_products.php',
	'orders.php',
	'brand.php',
	'type.php',
	'edit_product.php',
	'order_detail.php',
	'revenue.php',
	'statistic.php',
	'edit_brand.php',
	'users.php',
	'roles.php',
	'add_user.php'
];

if (in_array($page, $allowed_pages)) {
	include $page;
} else {
	echo "<p>Trang không hợp lệ.</p>";
}
