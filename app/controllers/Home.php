<?php

namespace app\controllers;

use app\database\models\User;

class Home
{
    private $user;

    public function __construct()
    {
        $this->user = new User;
    }

    public function index($request, $response)
    {
        $users = $this->user->find();

        render('site/home', ['users' => $users, 'title' => 'Home']);

        return $response;
    }
}
