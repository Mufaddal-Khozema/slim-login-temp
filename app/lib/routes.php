<?php
declare(strict_types=1);
use Slim\App;
use App\Controllers\PageController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;

$app->setBasePath("/slim-login");

return function (App $app) {
    $app->get('/', [PageController::class, 'home']); 
    $app->get('/login', [PageController::class, 'login']); 
    $app->get('/signup', [PageController::class, 'signup']); 
    $app->get('/welcome', [PageController::class, 'welcome'])->add(new AuthMiddleware);
    // $app->get('/signup/additional', [PageController::class, 'signupAdditional']);

    // $app->post('/createUser', [UserController::class, 'createUser']); 
    $app->post('/signup', [UserController::class, 'signup']); 
    $app->post('/loginUser', [UserController::class, 'loginUser']); 
    $app->get('/login/facebook', [UserController::class, 'facebookLogin']);
    $app->get('/login/google', [UserController::class, 'googleLogin']);
    $app->get('/login/facebook/callback', [UserController::class, 'facebookLoginCallback']);
    $app->get('/login/google/callback', [UserController::class, 'googleLoginCallback']);
};