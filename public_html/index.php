<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

define('ROOT_DIR', __DIR__ . '/../');

$application = (new AppBootstrap())->bootstrap();

$request = new \Core\Http\Request();
$response = $application->run($request, new \Core\AppExceptionHandler());
$response->send();