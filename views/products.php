<?php 

    session_start();

    $config = require_once dirname(__DIR__) . '/config/config.php';

    require_once dirname(__DIR__) . '/db/base.php';
    require_once dirname(__DIR__) . '/db/product.php';

    $db = new Database();
    $productDb = new Product();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Một số sản phẩm</title>
    <link rel="icon" type="image/x-icon" href="<?php echo $config['BASE_URL'] .'/assets/images/iassets/logo.png'; ?>">
    <?php require_once "lib.php"; ?>
</head>

<body>

    <div class="home_page">

        <?php require_once "header.php"; ?>

        <div class="content">

            <?php require_once 'list_brand.php'; ?>


            <?php require_once 'page_products.php'; ?>

            <br>

        </div>
        <?php require_once 'footer.php'; ?>

    </div>

</body>

</html>