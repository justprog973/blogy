<?php

use Framework\Blog\Actions\BlogAction;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Framework\Router\RouterTwigExtension;
use Framework\TwigRendererFactory;
use Psr\Container\ContainerInterface;

return [
    'database.host' => 'localhost',
    'database.username' => 'root',
    'database.password' => '',
    'database.name' => 'blogy',
    'views.path' => dirname(__DIR__) . DIRECTORY_SEPARATOR . "views",
    'twig.extensions' => [
        DI\get(RouterTwigExtension::class)
    ],
    Router::class => DI\create(),
    RendererInterface::class => DI\factory(TwigRendererFactory::class),
    \PDO::class => function (ContainerInterface $c) {
        return new PDO(
            "mysql:host=".$c->get('database.host').";
            dbname=".$c->get('database.name').";charset=utf8",
            $c->get('database.username'),
            $c->get('database.password'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    },
];
