<?php

namespace app\controllers;

use app\database\builder\Query;
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
        // $users = $this->user->findBy('id', 2);

        $users = Query::select('users.id,firstName,lastName')
        ->from('users')
        ->where('users.id', '>', 1)
        ->join('posts', 'posts.user_id = users.id')
        ->order('users.id', 'desc')
        ->get();

        var_dump($users);
        die();

        render('site/home', ['users' => $users, 'title' => 'Home']);

        return $response;
    }
}
