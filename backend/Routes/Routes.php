<?php

namespace Backend\Routes;

use Backend\Controllers\TodoController;

return [
    'GET' => [
        '/' => [TodoController::class, 'index'],
        // TODO詳細を実装
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
