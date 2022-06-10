<?php

use Slim\App;

use app\controllers\CartController;
use app\controllers\HomeController;

return function (App $app) {
    $app->get('/', [HomeController::class, 'index']);
    $app->post('/cart/add', [CartController::class, 'store']);
    $app->get('/cart/remove', [CartController::class, 'remove']);
    $app->post('/cart/clear', [CartController::class, 'destroy']);
};
