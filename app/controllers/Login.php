<?php

namespace app\controllers;

use app\classes\Flash;
use app\classes\Login as UserLogin;
use app\classes\Validate;

class Login
{
    private $login;

    public function __construct()
    {
        $this->login = new UserLogin;
    }

    public function index($request, $response)
    {
        render('site/login');

        return $response;
    }

    public function store($request, $response)
    {
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);

        $validate = new Validate;
        $validate->required(['email', 'password'])->email($email);
        $errors = $validate->getErrors();

        if ($errors) {
            return redirect($response, '/login');
        }

        $logged = $this->login->login($email, $password);

        if ($logged) {
            return redirect($response, '/');
        }

        Flash::set('message', 'Ocorreu um erro ao logar, tente novamente em alguns segundos', 'danger');

        return redirect($response, '/login');
    }

    public function destroy($request, $response)
    {
        $this->login->logout();

        return redirect($response, '/');
    }
}
