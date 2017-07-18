<?php
// Routes
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\HomeController;

$app->get('/admin/login', AuthController::class . ':login');

$app->post('/admin/login', AuthController::class . ':doLogin');

$app->get('/admin/home', HomeController::class . ':home');