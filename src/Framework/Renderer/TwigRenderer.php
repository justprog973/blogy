<?php

namespace Framework\Renderer;

class TwigRenderer implements RendererInterface
{
    private \Twig\Environment $twig;
    private \Twig\Loader\FilesystemLoader $loader;

    public function __construct(private string $path)
    {
        $this->loader = new \Twig\Loader\FilesystemLoader($path);
        $this->twig = new \Twig\Environment($this->loader, []);
    }

    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->loader->addPath($path, $namespace);
    }

    public function render(string $view, array $params = []): string
    {
        return $this->twig->render($view . ".html.twig", $params);
    }

    public function addGlobal(string $key, mixed $value): void
    {
        $this->twig->addGlobal($key, $value);
    }
}
