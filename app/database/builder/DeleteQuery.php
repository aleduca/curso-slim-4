<?php

namespace app\database\builder;

use Exception;

class DeleteQuery extends Builder
{
    private string $table;

    public static function table(string $table)
    {
        $self = new self;
        $self->table = $table;

        return $self;
    }


    private function createQuery()
    {
        if (!$this->table) {
            throw new Exception('A query precisa chamar o método table para deletar');
        }

        $query = "delete from {$this->table}";
        $query .= !empty($this->where) ? ' where ' . implode(' ', $this->where) : '';

        return $query;
    }


    public function delete()
    {
        $query = $this->createQuery();

        try {
            return $this->executeQuery($query, returnExecute:true);
        } catch (\PDOException $th) {
            var_dump($th->getMessage());
        }
    }
}
