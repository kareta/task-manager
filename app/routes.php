<?php

use Core\Routing\Router;

$router = new Router();

$router->setMiddleware(['Middleware\SessionMiddleware', 'Middleware\AuthMiddleware']);

$router->get('/auth/login', 'Controllers\LoginController@showLogin');

$router->post('/auth/login', 'Controllers\LoginController@login', [
    'Middleware\CsrfMiddleware'
]);

$router->get('/auth/logout', 'Controllers\LoginController@logout', [
    'Middleware\OnlyAuthenticatedMiddleware'
]);

$router->get('/tasks', 'Controllers\TaskController@index');

$router->post('/tasks', 'Controllers\TaskController@create');

$router->get('/tasks/(\\d+)/edit', 'Controllers\TaskController@getEditable', [
    'Middleware\OnlyAuthenticatedMiddleware'
]);

$router->post('/tasks/(\\d+)/edit', 'Controllers\TaskController@edit', [
    'Middleware\OnlyAuthenticatedMiddleware'
]);

$router->get('/tasks/(\\d+)/complete', 'Controllers\TaskController@complete', [
    'Middleware\OnlyAuthenticatedMiddleware'
]);

$router->get('/tasks-list', 'Controllers\TaskController@tasksList');

$router->get('/tasks/(\\d+)/image', 'Controllers\TaskController@getImage');

$router->get('/tasks/preview-image', 'Controllers\TaskController@previewImage');

$router->post('/tasks/preview', 'Controllers\TaskController@preview');

$router->get('/', 'Controllers\HomeController@index');

return $router;