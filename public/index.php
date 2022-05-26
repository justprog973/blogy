<?php

require "../vendor/autoload.php";

use App\Blog\BlogModule;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;

$modules = [
    BlogModule::class
];

$builder = new DI\ContainerBuilder();
$builder->addDefinitions(
    dirname(__DIR__)
        . DIRECTORY_SEPARATOR
        . "config"
        . DIRECTORY_SEPARATOR
        . "config.php"
);
foreach ($modules as $module) {
    if ($module::DEFINITIONS) {
        $builder->addDefinitions($module::DEFINITIONS);
    }
}
$builder->addDefinitions(
    dirname(__DIR__)
        . DIRECTORY_SEPARATOR
        . "config.php"
);


$container = $builder->build();

$app = new App($container, $modules);

$response = $app->run(ServerRequest::fromGlobals());

\Http\Response\send($response);
