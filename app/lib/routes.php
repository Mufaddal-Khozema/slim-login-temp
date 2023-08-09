<?php
declare(strict_types=1);
use Slim\App;
use App\Controllers\PageController;
use App\Controllers\UserController;

$app->setBasePath("/slim-login");

return function (App $app) {
    $app->get('/', [PageController::class, 'home']); 
    $app->get('/login', [PageController::class, 'login']); 
    $app->get('/signup', [PageController::class, 'signup']); 
    $app->post('/createUser', [UserController::class, 'createUser']); 
    $app->post('/loginUser', [UserController::class, 'loginUser']); 
    $app->get('/welcome', [PageController::class, 'welcome']);
    $app->get('/facebook/login', [UserController::class, 'facebookLogin']);
};