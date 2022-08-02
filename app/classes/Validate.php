<?php

namespace app\classes;

class Validate
{
    private $errors = [];

    public function required(array $fields)
    {
        foreach ($fields as $field) {
            if (empty($_POST[$field])) {
                Flash::set($field, 'Esse campo é obrigatório', 'danger');
                $this->errors[$field] = true;
            } else {
                Flash::set('old_' . $field, $_POST[$field]);
            }
        }

        return $this;
    }

    public function exist($model, $field, $value)
    {
        $data = $model->findBy($field, $value);

        if ($data) {
            Flash::set($field, 'Esse email já está cadastrado no banco de dados', 'danger');
            $this->errors[$field] = true;
        } else {
            Flash::set('old_' . $field, $_POST[$field]);
        }


        return $this;
    }

    public function email($email)
    {
        $validated = filter_var($email, FILTER_VALIDATE_EMAIL);

        if (!$validated) {
            Flash::set('email', 'Email inválido', 'danger');
            $this->errors['email'] = true;
        } else {
            Flash::set('old_email', $email);
        }
    }

    public function getErrors()
    {
        return !!$this->errors;
    }
}
