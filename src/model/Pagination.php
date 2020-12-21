<?php

namespace BrunoGrosdidier\Blog\src\model;

class Pagination
{
    private $limit;
    private $page;
    private $total;
    private $pageNumber;
    private $start;


    public function paginate($limit, $page, $total)
    {
        $this->setLimit($limit);
        $this->setPage($page);
        $this->setTotal($total);
        $this->setPageNumber($this->getTotal(), $limit);
        $this->setStart($this->getPage(), $limit);
        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    public function setPage($page)
    {
        if($page < 1) {
            $this->page = 1;
        } else {
            $this->page = $page;
        }
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    private function setPageNumber($total, $limit)
    {
        $this->pageNumber = ceil($total/$limit);
    }

    public function setStart($page, $limit)
    {
        $this->start = ($page - 1) * $limit;
    }
}
