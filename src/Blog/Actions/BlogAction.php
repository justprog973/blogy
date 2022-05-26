<?php

namespace App\Blog\Actions;

use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogAction
{

    public function __construct(private RendererInterface $renderer)
    {
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $slug = $request->getAttribute("slug");
        if ($slug) {
            return $this->show($slug);
        }
        return $this->index();
    }

    public function index(): string|ResponseInterface
    {
        return $this->renderer->render("@blog/index");
    }

    public function show(String $slug): string|ResponseInterface
    {
        return $this->renderer->render(
            "@blog/show",
            compact("slug")
        );
    }
}
