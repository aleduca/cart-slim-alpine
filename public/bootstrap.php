<?php
use Slim\Factory\AppFactory;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();

$app = AppFactory::create();

$routes = require '../app/routes/routes.php';

$routes($app);

$app->run();
