<?php
	$page = isset($_GET['page']) ? $_GET['page'] : 'add_product.php';
	$allowed_pages = [
		'add_product.php', 
		'list_product.php', 
		'discounted_products.php', 
		'orders.php',
		'brand.php',
		'type.php',
		'edit_product.php'
	];

	if (in_array($page, $allowed_pages)) {
	    include $page;
	} else {
	    echo "<p>Trang không hợp lệ.</p>";
	}
?>