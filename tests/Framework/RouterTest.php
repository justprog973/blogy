<?php

namespace Tests\Framework;

use Framework\Middleware\CallableMiddleware;
use Framework\Router;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;


    public function setUp(): void
    {
        $this->router = new Router();
    }

    public function testGetMethod()
    {
        $uri = "/blog";
        $request =  new ServerRequest("GET", $uri);
        $this->router->get($uri, new CallableMiddleware(function () {
            return "hello";
        }), "blog");
        $route = $this->router->mate($request);
        $this->assertEquals("blog", $route->getName());
        $this->assertEquals("hello", call_user_func_array($route->getCallback(), [$request]));
    }

    public function testGetMethodIfURLDoesNotExist()
    {
        $request =  new ServerRequest("GET", "/blog");
        $this->router->get('/blogass', new CallableMiddleware(function () {
            return "hello";
        }), "blog");
        $route = $this->router->mate($request);
        $this->assertEquals(null, $route);
    }

    public function testGetMethodWithParameters()
    {
        $routeName = "post.show";
        $request =  new ServerRequest("GET", "/blog/mon-slug-9");
        $this->router->get("/blog", new CallableMiddleware(function () {
            return "hello";
        }), $routeName);
        $this->router->get("/blog/{slug:[a-z0-9\-]+}-{id:\d+}", new CallableMiddleware(function () {
            return "hello";
        }), $routeName);
        $route = $this->router->mate($request);
        $this->assertEquals("post.show", $route->getName());
        $this->assertEquals("hello", call_user_func_array($route->getCallback(), [$request]));
        $this->assertEquals(["slug" => "mon-slug", "id" => "9"], $route->getParams());

        //Test invalid url

        $route = $this->router->mate(new ServerRequest("GET", "/blog/mon_slug-8"));

        $this->assertEquals(null, $route);
    }

    public function testGenerateUri()
    {
        $this->router->get("/blog", new CallableMiddleware(function () {
            return "azaearar";
        }), "posts");
        $this->router->get("/blog/{slug:[a-z0-9\-]+}-{id:\d+}", new CallableMiddleware(function () {
            return "hello";
        }), "post.show");

        $uri = $this->router->generateUri("post.show", ["slug" => "mon-article", "id" => 18]);

        $this->assertEquals("/blog/mon-article-18", $uri);
    }
}
