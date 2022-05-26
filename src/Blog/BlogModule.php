<?php

namespace App\Blog;

use Framework\Middleware\CallableMiddleware;
use Framework\Renderer;
use Framework\Router;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogModule
{
    private Renderer $renderer;

    public function __construct(Router $router, Renderer $renderer)
    {
        // Added path view
        $this->renderer = $renderer;
        $this->renderer->addPath("blog", __DIR__ . DIRECTORY_SEPARATOR . "views");

        //Initalized Route
        $router->get("/blog", new CallableMiddleware([$this, "index"]), "blog.index");
        $router->get("/blog/{slug:[a-z\-0-9]+}", new CallableMiddleware([$this, "show"]), "blog.show");
    }

    public function index(): string|Response
    {
        return $this->renderer->render("@blog/index");
    }

    public function show(Request $request): string|Response
    {
        return $this->renderer->render(
            "@blog/show",
            [
                "slug" => $request->getAttribute("slug")
            ]
        );
    }
}
