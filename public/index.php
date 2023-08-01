<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/db/db_conn.php';

$app = AppFactory::create();


$routes = require __DIR__ . '/../app/routes/routes.php';
$routes($app);

try {
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}