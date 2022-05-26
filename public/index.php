<?php

require "../vendor/autoload.php";

use App\Blog\BlogModule;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;

$app = new App([
    BlogModule::class
]);

$response = $app->run(ServerRequest::fromGlobals());

\Http\Response\send($response);
