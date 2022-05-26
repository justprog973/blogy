<?php

namespace Framework\Renderer;

class TwigRenderer implements RendererInterface
{
    public function __construct(
        private \Twig\Loader\FilesystemLoader $loader,
        private \Twig\Environment $twig
    ) {
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
