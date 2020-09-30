<?php

namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\database\models\User as ModelsUser;

class User extends Base
{
    private $validate;
    private $user;

    public function __construct()
    {
        $this->validate = new Validate;
        $this->user = new ModelsUser;
    }

    public function create($request, $response, $args)
    {
        $messages = Flash::getAll();

        return $this->getTwig()->render($response, $this->setView('site/user_create'), [
            'title' => 'User Create',
            'messages' => $messages
        ]);
    }

    public function edit($request, $response, $args)
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);

        $user = $this->user->findBy('id', $id);

        if (!$user) {
            Flash::set('message', 'Usuário não existe', 'danger');
            return redirect($response, '/');
        }

        $messages = Flash::getAll();

        return $this->getTwig()->render($response, $this->setView('site/user_edit'), [
            'title' => 'User edit',
            'user' => $user,
            'messages' => $messages
        ]);
    }

    public function store($request, $response, $args)
    {
        $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
        $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        $this->validate->required(['firstName', 'lastName', 'email', 'password'])->exist($this->user, 'email', $email)->email($email);
        $errors = $this->validate->getErrors();

        if ($errors) {
            Flash::flashes($errors);
            return redirect($response, '/user/create');
        }

        $created = $this->user->create(['firstName' => $firstName, 'lastName' => $lastName, 'email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);

        if ($created) {
            Flash::set('message', 'Cadastrado com sucesso');
            return redirect($response, '/');
        }

        Flash::set('message', 'Ocorreu um erro ao cadastrar o user');
        return redirect($response, '/user/create');

        return $response;
    }

    public function update($request, $response, $args)
    {
        $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
        $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);

        $this->validate->required(['firstName', 'lastName', 'email', 'password']);
        $errors = $this->validate->getErrors();

        if ($errors) {
            Flash::flashes($errors);
            return redirect($response, '/user/edit/' . $id);
        }

        $updated = $this->user->update(['fields' => ['firstName' => $firstName, 'lastName' => $lastName, 'email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)],
            'where' => ['id' => $id]]);

        if ($updated) {
            Flash::set('message', 'Atualziado com sucesso');
            return redirect($response, '/user/edit/' . $id);
        }

        Flash::set('message', 'Ocorreu um erro ao atualizar', 'danger');
        return redirect($response, '/user/edit/' . $id);
    }

    public function destroy($request, $response, $args)
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);

        $user = $this->user->findBy('id', $id);

        if (!$user) {
            Flash::set('message', 'Usuário não existe', 'danger');
            return redirect($response, '/');
        }

        $deleted = $this->user->delete('id', $id);

        if ($deleted) {
            Flash::set('message', 'Deletado com sucesso');
            return redirect($response, '/');
        }

        Flash::set('message', 'Ocorreu um erro ao deletar', 'danger');
        return redirect($response, '/');
    }
}
