<?php

use Backend\Controllers\TodoController;
use Backend\Database;
use Backend\Routes\Router;

$router = new Router();

$router->get('/', function () {
    $pdo = Database::connect_db();
    $todoController = new TodoController($pdo);

    if (isset($params['id'])) {
        return $todoController->get_by_id($params['id']);
    } else {
        return $todoController->get_test_all();
    }
});

$router->get('/admin', function () {
    return '認証実装する';
});

return $router;
