<?php
declare(strict_types=1);
use Slim\App;
require_once __DIR__ .'/../controllers/userController.php';
require_once __DIR__ .'/../controllers/pageController.php';

$app->setBasePath("/slim-login");

return function (App $app) {
    $app->get('/', "\PageController:home"); 
    $app->get('/login', "\PageController:login"); 
    $app->get('/signup', "\PageController:signup"); 
    $app->post('/createUser', "\UserController:createUser"); 
};