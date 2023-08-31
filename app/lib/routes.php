<?php
declare(strict_types=1);
use Slim\App;
use App\Controllers\PageController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
use App\Middleware\RedirectMiddleware;
use Slim\Routing\RouteCollectorProxy;

$app->setBasePath("/slim-login");

return function (App $app) {
    $app->get('/', [PageController::class, 'home']);
    $app->group('/', function (RouteCollectorProxy $group){
        $group->get('login', [PageController::class, 'login']); 
        $group->get('signup', [PageController::class, 'signup']); 
    })->add(new RedirectMiddleware); 
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