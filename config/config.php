<?php
return [
    'routes_path' => ROOT_DIR . 'app/routes.php',
    'views_path' => ROOT_DIR . 'views/',
    'images_path' => ROOT_DIR . 'storage/images/',

    'db' => [
        'database' => 'task_manager',
        'username' => 'root',
        'password' => 'root',
        'host' => 'localhost',
        'port' => '3306',
        'driver' => 'mysql'
    ]
];