<?php

namespace App\Blog;

use Framework\Middleware\CallableMiddleware;
use Framework\Router;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogModule
{
    public function __construct(Router $router)
    {
        $router->get("/blog", new CallableMiddleware([$this, "index"]), "blog.index");
        $router->get("/blog/{slug:[a-z\-]+}", new CallableMiddleware([$this, "show"]), "blog.show");
    }

    public function index(Request $request): string|Response
    {
        return "<h1>Bienvenue sur le blog</h1>";
    }

    public function show(Request $request): string|Response
    {
        return "<h1>Bienvenu sur l'article " . $request->getAttribute('slug') . "</h1>";
    }
}
