<?php

require "../vendor/autoload.php";

use App\Blog\BlogModule;
use Framework\App;
use Framework\Renderer;
use GuzzleHttp\Psr7\ServerRequest;

$renderer = new Renderer();
$renderer->addPath(dirname(__DIR__) . DIRECTORY_SEPARATOR . "views");

$app = new App([
    BlogModule::class
], [
    "renderer" => $renderer
]);

$response = $app->run(ServerRequest::fromGlobals());

\Http\Response\send($response);
