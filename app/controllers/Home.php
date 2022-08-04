<?php

namespace app\controllers;

use app\database\builder\Query;

class Home
{
    public function index($request, $response)
    {
        $users = Query::select('users.id,firstName,lastName')
        ->from('users')
        ->where('users.id', '>=', 1)
        ->join('posts', 'posts.user_id = users.id')
        ->order('users.id', 'desc')
        ->paginate(10);

        // $posts = Query::select()->from('posts')->where('id', '>', 30)->get();

        // var_dump($posts);

        render('site/home', ['users' => $users, 'title' => 'Home']);

        return $response;
    }
}
