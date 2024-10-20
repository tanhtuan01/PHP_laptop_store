<?php 

	$fePath = dirname(dirname(__DIR__)) . '/fe/edit_product.php';

	if(isset($_GET['id'])){
		echo $_GET['id'];
	}
	else{

	}

	require $fePath 
?>

