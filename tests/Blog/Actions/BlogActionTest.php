<?php

namespace Tests\App\Blog\Actions;

use App\Blog\Actions\BlogAction;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class BlogActionTest extends TestCase
{

    private  $actions;
    private  $renderer;
    private  $pdo;
    private  $router;

    public function setUp(): void
    {
        //Renderer
        $this->renderer = $this->prophesize(RendererInterface::class);
        $this->renderer->render()->willReturn('');

        //Article
        $post = new \stdClass();
        $post->id = 9;
        $post->slug = "demo-test";

        //PDO
        $this->pdo = $this->prophesize(\PDO::class);
        $pdoStatement = $this->prophesize(\PDOStatement::class);
        $this->pdo->prepare(Argument::any())->willReturn($pdoStatement);
        $pdoStatement->fetch()->willReturn($post);

        // Router
        $this->router = $this->prophesize(Router::class);
        $this->action = new BlogAction(
            $this->renderer->reveal(),
            $this->pdo->reveal(),
            $this->router->reveal()
        );
    }

    public function testShowRedirect()
    {
        $request = (new ServerRequest('GET', '/'))
            ->withAttribute('id', 9)
            ->withAttribute('slug', 'demo');
        $response = call_user_func_array($this->actions, [$request]);

        $this->assertEquals(301, $response->getStatusCode());
    }
}
