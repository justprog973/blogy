<?php

namespace Tests\Framework;

use App\Blog\BlogModule;
use PHPUnit\Framework\TestCase;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use Tests\Framework\Modules\ErroredModule;
use Tests\Framework\Modules\StringModule;

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
        $app = new App([
            BlogModule::class
        ]);

        $request = new ServerRequest("GET", "/blog");
        $requestSingle = new ServerRequest("GET", "/blog/article-de-test");

        $responseSingle = $app->run($requestSingle);
        $response = $app->run($request);


        $this->assertEquals("<h1>Bienvenu sur l'article article-de-test</h1>", (string)$responseSingle->getBody());
        $this->assertEquals("<h1>Bienvenue sur le blog</h1>", (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testThrowExceptionIfNotResponseSent()
    {
        $app = new App([
            ErroredModule::class
        ]);

        $request = new ServerRequest("GET", "/demo");

        $this->expectException(\Exception::class);
        $app->run($request);
    }

    public function testIfSentStringModule()
    {
        $app = new App([
            StringModule::class
        ]);

        $request = new ServerRequest("GET", "/demo");
        $reponse = $app->run($request);

        $this->assertEquals("<h1>Bienvenue sur le string module</h1>", (string)$reponse->getBody());
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
