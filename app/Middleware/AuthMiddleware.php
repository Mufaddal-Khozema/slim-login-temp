<?php
namespace App\Middleware;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response; 
class AuthMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $response = new Response();
        if(!isset($_SESSION['auth'])) return $response->withStatus(401);
        $response = $handler->handle($request);
        return $response;
    }
}