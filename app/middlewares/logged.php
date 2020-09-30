<?php

use Slim\Psr7\Response;

$logged = function ($request, $handler) {
    $response = $handler->handle($request);
    $existingContent = (string) $response->getBody();

    $response = new Response();
    $response->getBody()->write($existingContent);

    if (!isset($_SESSION['is_logged_in'])) {
        return redirect($response, '/');
    }

    return $response;
};
