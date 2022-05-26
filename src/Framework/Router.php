<?php

namespace Framework;

use Framework\Router\Route;
use Mezzio\Router\FastRouteRouter;
use Mezzio\Router\Route as MezzioRoute;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

/**
 * Router
 *
 * Register and match routes
 */
class Router
{

    private FastRouteRouter $router;

    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    /**
     * get
     *
     * @param  string $path
     * @param  MiddlewareInterface $callable
     * @param  string $name
     * @return void
     */
    public function get(string $path, MiddlewareInterface $callable, string $name)
    {
        $this->router->addRoute(new MezzioRoute($path, $callable, ["GET"], $name));
    }

    /**
     * match
     *
     * @param  ServerRequestInterface $request
     * @return Route|null
     */
    public function mate(ServerRequestInterface $request): ?Route
    {
        $result = $this->router->match($request);

        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedRoute()->getMiddleware()->getCallable(),
                $result->getMatchedParams()
            );
        }

        return null;
    }

    public function generateUri(string $name, array $params): ?string
    {
        return $this->router->generateUri($name, $params);
    }
}
