<?php

namespace app\controllers;

use app\database\builder\DeleteQuery;
use app\database\builder\InsertQuery;
use app\database\builder\ReadQuery;
use app\database\builder\UpdateQuery;

class Home
{
    public function index($request, $response)
    {
        $search = $_GET['s'] ?? '';

        $users = ReadQuery::select('users.id,firstName,lastName')
        ->from('users')
        ->where('users.id', '>=', 1, 'and')
        ->where('firstName', 'like', "%{$search}%")
        ->order('users.id', 'desc')
        ->paginate(10);

        var_dump($users->query);

        // $updated = UpdateQuery::table('users')->set([
        //     'firstName' => 'Marcos',
        //     'lastName' => 'Santos',
        // ])->where('id', '=', 20)->update();


        // $deleted = DeleteQuery::table('users')->where('id', '=', 20)->delete();

        // $crated = InsertQuery::into('users')->insert([
        //     'firstName' => 'Alexandre',
        //     'lastName' => 'Cardoso',
        //     'email' => 'xandecar@hotmail.com',
        //     'password' => password_hash('123', PASSWORD_DEFAULT),
        // ]);

        // var_dump($crated);

        render('site/home', ['users' => $users, 'title' => 'Home']);

        return $response;
    }
}
