<?php

namespace Framework;

use Exception;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{

    private array $modules = [];
    private Router $router;

    /**
     *
     * @param string[] $modules #List of modules to loading
     */
    public function __construct(array $modules = [], array $dependencies = [])
    {
        $this->router = new Router();
        if (array_key_exists("renderer", $dependencies)) {
            $dependencies["renderer"]->addGlobal("router", $this->router);
        }
        foreach ($modules as $module) {
            $this->modules[] = new $module($this->router, $dependencies["renderer"]);
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

        $route = $this->router->mate($request);

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

        $response = call_user_func_array($route->getCallback(), [$request]);

        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new Exception("The response is not a string or not an instance of ResponseInterface.");
        }
    }
}
