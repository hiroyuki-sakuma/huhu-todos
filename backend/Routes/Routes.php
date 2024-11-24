<?php

namespace Backend\Routes;

use Backend\Controllers\TodoController;
use Backend\Controllers\AuthController;
use Backend\Controllers\UserController;

return [
    'GET' => [
        '/' => [TodoController::class, 'index'],
        '/auth' => [AuthController::class, 'check_auth'],
        '/user' => [UserController::class, 'get_user_by_token'],
        '/password-reset' => [UserController::class, 'verify_reset_token']
    ],
    'POST' => [
        '/' => [TodoController::class, 'store'],
        '/login' => [AuthController::class, 'login'],
        '/logout' => [AuthController::class, 'logout'],
        '/forgot-password' => [UserController::class, 'email_reset_password_link'],
        '/password-reset' => [UserController::class, 'update_password']
    ],
    'PUT' => [
        '/{id}' => [TodoController::class, 'update']
    ],
    'DELETE' => [
        '/{id}' => [TodoController::class, 'delete']
    ]
];
