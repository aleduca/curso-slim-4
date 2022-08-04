<?php

namespace app\database\builder;

use app\database\Connection;
use Exception;

class UpdateQuery
{
    private string $table;
    private array $data = [];
    private array $where = [];
    private array $binds = [];

    public static function table(string $table)
    {
        $self = new self;
        $self->table = $table;

        return $self;
    }

    public function set(array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function where(string $field, string $operator, string|int $value, ?string $logic = null)
    {
        $fieldPlaceholder = $field;

        if (str_contains($fieldPlaceholder, '.')) {
            $fieldPlaceholder = str_replace('.', '', $fieldPlaceholder);
        }

        $this->where[] = "{$field} {$operator} :{$fieldPlaceholder} {$logic}";

        $this->binds[$fieldPlaceholder] = $value;

        return $this;
    }

    private function createQuery(bool $count = false)
    {
        if (!$this->table) {
            throw new Exception('A query precisa chamar o método table');
        }

        if (!$this->data) {
            throw new Exception('A query precisa de dados para atualizar');
        }

        $query = "update {$this->table} set ";
        foreach ($this->data as $field => $value) {
            $query .= "{$field} = :{$field},";
            $this->binds[$field] = $value;
        }

        $query = rtrim($query, ',');
        $query .= !empty($this->where) ? ' where ' . implode(' ', $this->where) : '';

        return $query;
    }

    private function executeQuery($query)
    {
        $connection = Connection::getConnection();
        $prepare = $connection->prepare($query);

        return $prepare->execute($this->binds ?? []);
    }


    public function update()
    {
        $query = $this->createQuery();

        try {
            return $this->executeQuery($query);
        } catch (\PDOException $th) {
            var_dump($th->getMessage());
        }
    }
}
