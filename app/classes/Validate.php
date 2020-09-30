<?php

namespace app\classes;

class Validate
{
    private $errors = [];

    public function required(array $fields)
    {
        foreach ($fields as $field) {
            if (empty($_POST[$field])) {
                $this->errors[$field] = 'O campo é obrigatório';
            }
        }

        return $this;
    }

    public function exist($model, $field, $value)
    {
        $data = $model->findBy($field, $value);

        if ($data) {
            $this->errors[$field] = 'Esse email já está cadastrado no banco de dados';
        }

        return $this;
    }

    public function email($email)
    {
        $validated = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$validated) {
            $this->errors['email'] = 'Email inválido';
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
