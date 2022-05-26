<?php

namespace Framework\Router;

use Framework\Router;

class RouterTwigExtension extends \Twig\Extension\AbstractExtension
{

    public function __construct(private Router $router)
    {
    }

    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction("path", [$this, "pathFor"])
        ];
    }


    public function pathFor(string $path, ?array $params = []): string
    {
        return $this->router->generateUri($path, $params);
    }
}
