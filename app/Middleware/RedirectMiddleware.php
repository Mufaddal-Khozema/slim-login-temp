<?php
namespace App\Middleware;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
// use Slim\Http\Response;
use Slim\Psr7\Response; 
class RedirectMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $response = new Response();
        if(isset($_SESSION['auth'])) return $response->withHeader('Location', 'welcome')->withStatus(302);
        $response = $handler->handle($request);
        return $response;
    }
}