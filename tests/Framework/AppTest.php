<?php

namespace Tests\Framework;

use PHPUnit\Framework\TestCase;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;

class AppTest extends TestCase
{
    public function testRedirectTrainlingSlash()
    {
        $app = new App();
        $request = new ServerRequest("GET", "/testslach/");
        $response = $app->run($request);
        $this->assertContains("/testslach", $response->getHeader("Location"));
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function testBlog()
    {
        $app = new App();

        $request = new ServerRequest("GET", "/blog");

        $response = $app->run($request);

        $this->assertEquals("<h1>Bienvenue sur le blog</h1>", (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testError404()
    {
        $app = new App();

        $request = new ServerRequest("GET", "/adda");

        $response = $app->run($request);

        $this->assertEquals("<h1>Erreur 404</h1>", (string)$response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
    }
}
