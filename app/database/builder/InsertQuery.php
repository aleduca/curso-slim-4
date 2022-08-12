<?php

namespace app\database\builder;

use Exception;

class InsertQuery extends Builder
{
    private string $table;

    // insert into users(firstName, lastName, email, password) values(:firstName, :lastName, :email, :password)
    public static function into(string $table)
    {
        $self = new self;
        $self->table = $table;

        return $self;
    }

    private function createQuery()
    {
        if (!$this->table) {
            throw new Exception('A query precisa chamar o método into');
        }

        if (!$this->binds) {
            throw new Exception('A query precisa dos dados para cadastrar');
        }

        $query = "insert into {$this->table}(";
        $query .= implode(',', array_keys($this->binds)) . ') VALUES(';
        $query .= ':' . implode(',:', array_keys($this->binds)) . ')';

        return $query;
    }


    public function insert(array $data)
    {
        $this->binds = $data;

        $query = $this->createQuery();

        try {
            return $this->executeQuery($query, returnExecute:true);
        } catch (\PDOException $th) {
            var_dump($th->getMessage());
        }
    }
}
