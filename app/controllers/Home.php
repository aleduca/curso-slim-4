<?php

namespace app\controllers;

use app\database\builder\InsertQuery;
use app\database\builder\ReadQuery;

class Home
{
    public function index($request, $response)
    {
        // $users = ReadQuery::select('users.id,firstName,lastName')
        // ->from('users')
        // ->where('users.id', '>=', 1)
        // ->join('posts', 'posts.user_id = users.id')
        // ->order('users.id', 'desc')
        // ->paginate(10);

        $crated = InsertQuery::into('users')->insert([
            'firstName' => 'Alexandre',
            'lastName' => 'Cardoso',
            'email' => 'xandecar@hotmail.com',
            'password' => password_hash('123', PASSWORD_DEFAULT),
        ]);

        var_dump($crated);

        // render('site/home', ['users' => $users, 'title' => 'Home']);

        return $response;
    }
}
