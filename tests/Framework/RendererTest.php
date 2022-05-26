<?php

namespace Tests\Framework;

use Framework\Renderer;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{
    private Renderer $renderer;

    public function setUp(): void
    {
        $this->renderer = new Renderer();
        $this->renderer->addPath(__DIR__ . "/views");
    }

    public function testRenderTheRightPath()
    {
        $this->renderer->addPath("blog",__DIR__ . "/views");
        $content = $this->renderer->render("@blog/demo");

        $this->assertEquals("justprog", $content);
    }

    public function testRenderTheDefaultPath()
    {
        $content = $this->renderer->render("demo");

        $this->assertEquals("justprog", $content);
    }

    public function testRenderWithParams()
    {
        $content = $this->renderer->render("demoparams",["domaine" => "dev"]);

        $this->assertEquals("justprog dev", $content);
    }

    public function testGlobalParameters()
    {
        $this->renderer->addGlobal("domaine", "dev");
        $content = $this->renderer->render("demoparams");

        $this->assertEquals("justprog dev", $content);
    }
}
