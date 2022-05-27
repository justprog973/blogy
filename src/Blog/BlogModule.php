<?php

namespace App\Blog;

use App\Blog\Actions\BlogAction;
use Framework\Middleware\CallableMiddleware;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router;

class BlogModule extends Module
{
    const DEFINITIONS = __DIR__ . DIRECTORY_SEPARATOR . "config.php";
    const MIGRATIONS = __DIR__ . DIRECTORY_SEPARATOR . "db" . DIRECTORY_SEPARATOR . "migrations";
    const SEEDS = __DIR__ . DIRECTORY_SEPARATOR . "db" . DIRECTORY_SEPARATOR . "seeds";

    public function __construct(string $prefix, Router $router, private RendererInterface $renderer)
    {
        // Added path view
        $this->renderer = $renderer;
        $this->renderer->addPath("blog", __DIR__ . DIRECTORY_SEPARATOR . "views");


        //Initalized Route
        $router->get($prefix, new CallableMiddleware(BlogAction::class), "blog.index");
        $router->get("$prefix/{slug:[a-z\-0-9]+}-{id:[0-9]+}", new CallableMiddleware(BlogAction::class), "blog.show");
    }
}
