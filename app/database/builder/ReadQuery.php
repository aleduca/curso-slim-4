<?php

namespace app\database\builder;

use Exception;

class ReadQuery extends Builder
{
    private ?string $table = null;
    private ?string $fields = null;
    private string $order;
    private string $group;
    private array $join = [];

    public static function select(string $fields = '*')
    {
        $self = new self;
        $self->fields = $fields;

        return $self;
    }

    public function from(string $table)
    {
        $this->table = $table;

        return $this;
    }

    public function join(string $foreignTable, string $logic, string $type = 'inner')
    {
        $this->join[] = " {$type} join {$foreignTable} on {$logic}";

        return $this;
    }


    public function order(string $field, string $value)
    {
        $this->order = " order by {$field} {$value}";

        return $this;
    }

    public function group(string $field)
    {
        $this->group = " group by {$field}";

        return $this;
    }

    private function createQuery(bool $count = false)
    {
        if (!$this->fields) {
            throw new Exception('A query precisa chamar o método select');
        }

        if (!$this->table) {
            throw new Exception('A query precisa chamar o método from');
        }

        $query = ($count) ? 'select count(*) as count ' : 'select ';
        $query .= (!$count) ? $this->fields . ' from ' : 'from ';
        $query .= $this->table;
        $query .= !empty($this->join) ? implode(' ', $this->join) : '';
        $query .= !empty($this->where) ? ' where ' . implode(' ', $this->where) : '';
        $query .= $this->group ?? '';
        $query .= $this->order ?? '';

        return $query;
    }



    public function get()
    {
        $query = $this->createQuery();

        $this->query['get'][] = $query;

        try {
            $prepare = $this->executeQuery($query);

            return (object)['rows' => $prepare->fetchAll(), 'query' => $this->query];
        } catch (\PDOException $th) {
            var_dump($th->getMessage());
        }
    }

    public function first()
    {
        $query = $this->createQuery();

        $this->query['first'][] = $query;

        try {
            $prepare = $this->executeQuery($query);

            return (object)['register' => $prepare->fetchObject(), 'query' => $this->query];
        } catch (\PDOException $th) {
            var_dump($th->getMessage());
        }
    }

    private function getPaginateInstanceAndConfig(int $itemsPerPage): Paginate
    {
        $query = $this->createQuery(count:true);

        $paginate = new Paginate;
        $paginate->setItemsPerPage($itemsPerPage);
        $paginate->setPageIdentification('page');
        $paginate->setQueryCount($query);
        $paginate->setBinds($this->binds ?? []);
        // $paginate->setLinksPerPage(10);

        $this->query['paginate'][] = $query;

        return $paginate;
    }

    private function getQueryToPaginate(Paginate $paginate)
    {
        $queryToPaginate = $this->createQuery();
        $queryToPaginate .= $paginate->queryToPaginate();

        $this->query['paginate'][] = $queryToPaginate;

        return $queryToPaginate;
    }

    public function paginate(int $itemsPerPage = 10)
    {
        $paginate = $this->getPaginateInstanceAndConfig($itemsPerPage);
        $prepare = $this->executeQuery($this->getQueryToPaginate($paginate), returnExecute:false);

        return (object)['rows' => $prepare->fetchAll(), 'render' => $paginate->render(), 'query' => $this->query];
    }
}
