<?php

namespace Tests\Framework\Modules;

use Framework\Middleware\CallableMiddleware;
use Framework\Router;

class StringModule
{

    public function __construct(Router $router)
    {
        $router->get("/demo", new CallableMiddleware(function () {
            return "<h1>Bienvenue sur le string module</h1>";
        }), "strmodule");
    }
}
