<?php

$brands = $db->findAll('t_brand');

?>


<div class="category">
    <?php if ($brands) {
        foreach ($brands as $brand) { ?>
            <a href="views/brand.php?id=<?php echo $brand['id']; ?>" class="item">
                <img src="<?php echo $config['BASE_URL'] . "/assets/images/brands/" . $brand['image']; ?> " alt="">
            </a>
    <?php }
    } ?>
</div>