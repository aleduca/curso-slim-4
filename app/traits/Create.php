<?php

namespace app\traits;

use PDOException;

trait Create
{
    public function create(array $createFieldsAndValues)
    {
        try {
            $sql = sprintf('insert into %s (%s) values(%s)', $this->table, implode(',', array_keys($createFieldsAndValues)), ':' . implode(',:', array_keys($createFieldsAndValues)));
            $prepared = $this->connection->prepare($sql);
            return $prepared->execute($createFieldsAndValues);
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }
}
