<?php 

    require_once (dirname(__DIR__)) . '/db/base.php';
    
    $db = new Database();

    $config = require_once (dirname(__DIR__)) . '/config/config.php';
    
    if(!isset($_GET['q']) || !$_GET['q']){
        header("Location: ../index.php");
    }

    $q = trim($_GET['q']);

?>

<?php
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $paginationData = $db->findWithPagination('t_product', [], 'name' ,$q, 'id', 'DESC', $config['DEFAULT_SEARCH_SIZE'], $page);

    $products = $paginationData['data'];
    $totalPages = $paginationData['last_page'];
    $currentPage = $paginationData['current_page'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <link rel="icon" type="image/x-icon" href="<?php echo $config['BASE_URL'] .'/assets/images/iassets/logo.png'; ?>">
    <?php require_once "lib.php"; ?>
</head>

<body>

    <div class="home_page">

        <?php require_once "header.php"; ?>

        <div class="content">

            <?php require_once 'page_search.php'; ?>

            <br>

        </div>
        <?php require_once 'footer.php'; ?>

    </div>

</body>

</html>