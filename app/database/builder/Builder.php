<?php

namespace app\database\builder;

use app\database\Connection;

abstract class Builder
{
    protected array $binds = [];
    protected array $where = [];
    protected array $query = [];

    public function where(string $field, string $operator, string|int $value, ?string $logic = null)
    {
        $fieldPlaceholder = $field;

        if (str_contains($fieldPlaceholder, '.')) {
            $fieldPlaceholder = str_replace('.', '', $fieldPlaceholder);
        }

        $this->where[] = "{$field} {$operator} :{$fieldPlaceholder} {$logic}";

        $this->binds[$fieldPlaceholder] = strip_tags($value);

        return $this;
    }

    protected function executeQuery($query, $returnExecute = false)
    {
        $connection = Connection::getConnection();
        $prepare = $connection->prepare($query);

        $execute = $prepare->execute($this->binds ?? []);

        return ($returnExecute) ? $execute : $prepare;
    }
}
