<?php

namespace Backend\Routes;

use Backend\Controllers\TodoController;
use Backend\Controllers\AuthController;
use Backend\Controllers\UserController;

return [
    'GET' => [
        '/' => [TodoController::class, 'index'],
        // '/{id}' => [TodoController::class, 'get_by_id'],
        '/auth' => [AuthController::class, 'check_auth'],
        '/user' => [UserController::class, 'get_user_by_token']
    ],
    'POST' => [
        '/' => [TodoController::class, 'store'],
        '/login' => [AuthController::class, 'login'],
        '/logout' => [AuthController::class, 'logout'],
        '/password-reset-form' => [UserController::class, 'reset_password_email'],
    ],
    'PUT' => [
        '/{id}' => [TodoController::class, 'update']
    ],
    'DELETE' => [
        '/{id}' => [TodoController::class, 'delete']
    ]
];
