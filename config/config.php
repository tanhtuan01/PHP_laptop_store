<?php

$config = [
    'HOST' => 'http://localhost/',
    'PROJECT_NAME' => 'Laptop Store',
    'ROOT_FOLDER' => 'TMPWEB',
    'DEFAULT_PAGE_SIZE' => 12,
    'DEFAULT_SEARCH_SIZE' => 12,
    'EMAIL' => 'Email Address',
    'ADDRESS' => 'Shop Address',
    'HOTLINE' => 'Hotline'
];

$config['BASE_URL'] = $config['HOST'] . $config['ROOT_FOLDER'];

return $config;