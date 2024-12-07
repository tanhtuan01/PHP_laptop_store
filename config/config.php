<?php

$config = [
    'HOST' => 'http://localhost/',
    'PROJECT_NAME' => 'Laptop Store',
    'ROOT_FOLDER' => 'TMPWEB',
    'DEFAULT_PAGE_SIZE' => 12,
    'DEFAULT_SEARCH_SIZE' => 12,
    'EMAIL' => 'Email Address',
    'ADDRESS' => 'Shop Address',
    'HOTLINE' => 'Hotline',
    'PRODUCT_IMAGE_FOLDER' => '/assets/images/products/',
    'BRAND_IMAGE_FOLDER' => '/assets/images/brands/',
    'INDEX_PRODUCT_DISCOUNT_NUMBER' => 10,
    'INDEX_PRODUCT_NUMBER' => 10,
];

$config['BASE_URL'] = $config['HOST'] . $config['ROOT_FOLDER'];
$config['PRODUCT_IMAGE'] = $config['BASE_URL'] . $config['PRODUCT_IMAGE_FOLDER'];
$config['BRAND_IMAGE'] =  $config['BASE_URL'] . $config['BRAND_IMAGE_FOLDER'];
$config['JS'] = $config['BASE_URL'] .'/assets/js/';

return $config;