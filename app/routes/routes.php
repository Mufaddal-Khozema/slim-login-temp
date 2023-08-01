<?php
declare(strict_types=1);
use Slim\App;
require_once __DIR__ .'/../controllers/userController.php';

$app->setBasePath("/slim-login");

return function (App $app) {
    $app->get('/login', "\UserController:login"); 
    $app->get('/', "\UserController:home"); 

};