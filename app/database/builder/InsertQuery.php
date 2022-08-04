<?php

namespace app\database\builder;

use app\database\Connection;
use Exception;

class InsertQuery
{
    private string $table;
    private array $data = [];

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

        if (!$this->data) {
            throw new Exception('A query precisa dos dados para cadastrar');
        }

        $query = "insert into {$this->table}(";
        $query .= implode(',', array_keys($this->data)) . ') VALUES(';
        $query .= ':' . implode(',:', array_keys($this->data)) . ')';

        return $query;
    }


    private function executeQuery($query)
    {
        $connection = Connection::getConnection();
        $prepare = $connection->prepare($query);

        return $prepare->execute($this->data);
    }

    public function insert(array $data)
    {
        $this->data = $data;

        $query = $this->createQuery();

        try {
            return $this->executeQuery($query);
        } catch (\PDOException $th) {
            var_dump($th->getMessage());
        }
    }
}
