<?php

use Framework\Blog\Actions\BlogAction;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Framework\Router\RouterTwigExtension;
use Framework\TwigRendererFactory;

return [
    "views.path" => dirname(__DIR__) . DIRECTORY_SEPARATOR . "views",
    "twig.extensions" => [
        DI\get(RouterTwigExtension::class)
    ],
    Router::class => DI\create(),
    RendererInterface::class => DI\factory(TwigRendererFactory::class)
];
