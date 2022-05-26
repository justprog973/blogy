<?php

namespace Framework;

use Exception;
use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{

    private ContainerInterface $container;
    /**
     * __construct
     *
     * @param  ContainerInterface $container
     * @param  array $modules
     * @return void
     */
    public function __construct(ContainerInterface $container, array $modules = [])
    {
        $this->container = $container;
        foreach ($modules as $module) {
            $this->modules[] = $container->get($module);
        }
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();

        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader("Location", substr($uri, 0, -1));
        }

        $route = $this->container->get(Router::class)->mate($request);

        if (is_null($route)) {
            return new Response(404, [], "<h1>Erreur 404</h1>");
        }

        $params = $route->getParams();
        $request = array_reduce(
            array_keys($params),
            function (ServerRequestInterface $request, string $key) use ($params) {
                return $request->withAttribute($key, $params[$key]);
            },
            $request
        );

        $callback = $route->getCallback();

        if (is_string($callback)) {
            $callback = $this->container->get($callback);
        }

        $response = call_user_func_array($callback, [$request]);

        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new Exception("The response is not a string or not an instance of ResponseInterface.");
        }
    }
}
