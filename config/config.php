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
    'PRODUCT_IMAGE_FOLDER' => '/assets/images/products/'
];

$config['BASE_URL'] = $config['HOST'] . $config['ROOT_FOLDER'];
$config['PRODUCT_IMAGE'] = $config['BASE_URL'] . $config['PRODUCT_IMAGE_FOLDER'];

return $config;