<?php

namespace app\database\builder;

use app\database\Connection;

class Paginate
{
    private int $currentPage = 1;
    private string $pageIdentification = 'page';
    private int $itemsPerPage = 10;
    private int $linksPerPage = 5;
    private int $totalPages;
    private int $offset = 0;
    private int $totalItems;
    private array $binds;

    public function setItemsPerPage(int $itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }

    public function setPageIdentification(string $pageIdentification)
    {
        $this->pageIdentification = $pageIdentification;
    }

    public function setQueryCount(string $queryCount)
    {
        $this->queryCount = $queryCount;
    }

    public function setLinksPerPage(int $linksPerPage)
    {
        $this->linksPerPage = $linksPerPage;
    }

    public function setBinds(array $binds)
    {
        $this->binds = $binds;
    }

    private function calculations()
    {
        $this->currentPage = isset($_GET[$this->pageIdentification]) ? (int)$_GET[$this->pageIdentification] : 1;
        $this->offset = ($this->currentPage - 1) * $this->itemsPerPage;
        $this->totalPages = ceil($this->totalItems / $this->itemsPerPage);
    }

    private function getCount()
    {
        $connection = Connection::getConnection();
        $prepare = $connection->prepare($this->queryCount);
        $prepare->execute($this->binds);

        $this->totalItems = $prepare->fetchObject()->count;
    }

    public function render()
    {
        $links = '<ul class="pagination">';

        if ($this->currentPage > 1) {
            $previous = $this->currentPage - 1;
            $linkPreviousPage = http_build_query(array_merge($_GET, [$this->pageIdentification => $previous]));
            $first = http_build_query(array_merge($_GET, [$this->pageIdentification => 1]));
            $links .= "<li class='page-item'><a href='?{$first}' class='page-link'>Primeira</a></li>";
            $links .= "<li class='page-item'><a href='?{$linkPreviousPage}' class='page-link'>Anterior</a></li>";
        }

        for ($i = $this->currentPage - $this->linksPerPage; $i <= $this->currentPage + $this->linksPerPage ; $i++) {
            if ($i > 0 && $i <= $this->totalPages) {
                $class = $this->currentPage === $i ? 'active' : '';
                $linkPage = http_build_query(array_merge($_GET, [$this->pageIdentification => $i]));
                $links .= "<li class='page-item {$class}'><a href='?{$linkPage}' class='page-link'>{$i}</a></li>";
            }
        }

        if ($this->currentPage < $this->totalPages) {
            $next = $this->currentPage + 1;
            $linkNextPage = http_build_query(array_merge($_GET, [$this->pageIdentification => $next]));
            $last = http_build_query(array_merge($_GET, [$this->pageIdentification => $this->totalPages]));
            $links .= "<li class='page-item'><a href='?{$linkNextPage}' class='page-link'>Próxima</a></li>";
            $links .= "<li class='page-item'><a href='?{$last}' class='page-link'>Última</a></li>";
        }

        $links .= '</ul>';

        return $links;
    }

    public function queryToPaginate()
    {
        $this->getCount();
        $this->calculations();

        return " limit {$this->itemsPerPage} offset {$this->offset}";
    }
}
