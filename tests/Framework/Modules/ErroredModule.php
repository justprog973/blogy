<?php

namespace Tests\Framework\Modules;

use Framework\Middleware\CallableMiddleware;
use Framework\Router;

class ErroredModule
{

    public function __construct(Router $router)
    {
        $router->get("/demo", new CallableMiddleware(function () {
            return new \stdClass;
        }), "name");
    }
}
