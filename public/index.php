<?php

session_start();

require '../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;

$app = AppFactory::create();

require '../app/routes/site.php';
require '../app/routes/user.php';

$methodOverrideMiddleware = new MethodOverrideMiddleware();
$app->add($methodOverrideMiddleware);

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    $response->getBody()->write('Something wrong');
    return $response;
});

$app->run();
