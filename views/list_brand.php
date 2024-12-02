<?php

$brands = $db->findAll('t_brand');

?>


<div class="row">
    <div class="title-more">
        <h3 class="title-block">Danh mục Laptop</h3>
        <!-- <a class="btn btn-more">Xem nhiều hơn </a> -->
    </div>
    <div class="category">
        <?php if ($brands) {
        foreach ($brands as $brand) { ?>
        <a href="<?php echo $config['BASE_URL'] .'/views/brand.php?id=' . $brand['id']; ?>" class="item">
            <img src="<?php echo $config['BASE_URL'] . "/assets/images/brands/" . $brand['image']; ?> " alt="">
            <p class="brand-name"><?php echo $brand['name']; ?></p>
        </a>
        <?php }
    } ?>
    </div>
</div>