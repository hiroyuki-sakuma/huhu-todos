<?php

namespace Backend\Routes;

use Backend\Controllers\TodoController;
use Backend\Controllers\AuthController;

return [
    'GET' => [
        '/' => [TodoController::class, 'index'],
        '/{id}' => [TodoController::class, 'get_by_id'],
        '/auth' => [AuthController::class, 'check_auth'],
    ],
    'POST' => [
        '/' => [TodoController::class, 'store'],
        '/login' => [AuthController::class, 'login'],
        '/logout' => [AuthController::class, 'logout'],
    ],
    'PUT' => [
        '/{id}' => [TodoController::class, 'update']
    ],
    'DELETE' => [
        '/{id}' => [TodoController::class, 'delete']
    ]
];
