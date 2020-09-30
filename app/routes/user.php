<?php

use app\controllers\User;

require '../app/middlewares/logged.php';

$app->get('/user/create', User::class . ':create')->add($logged);
$app->get('/user/edit/{id}', User::class . ':edit');
$app->post('/user/store', User::class . ':store');
$app->put('/user/update/{id}', User::class . ':update');
$app->delete('/user/delete/{id}', User::class . ':destroy');
