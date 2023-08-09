<?php
// session_start(); 
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/db/db_conn.php';

$app = AppFactory::create();


$routes = require __DIR__ . '/app/lib/routes.php';
$routes($app);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->run();