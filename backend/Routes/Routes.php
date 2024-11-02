<?php

namespace Backend\Routes;

use Backend\Controllers\TodoController;

return [
    'GET' => [
        '/' => [TodoController::class, 'index'],
        '/{id}' => [TodoController::class, 'get_by_id'],
    ],
    'POST' => [
        '/' => [TodoController::class, 'store']
    ],
    'PUT' => [
        '/{id}' => [TodoController::class, 'update']
    ],
    'DELETE' => [
        '/{id}' => [TodoController::class, 'delete']
    ]
];
