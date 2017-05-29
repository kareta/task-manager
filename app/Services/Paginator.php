<?php

namespace Services;


class Paginator
{
    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $perpage;

    /**
     * @var int
     */
    protected $count;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * Paginator constructor.
     * @param int $page
     * @param int $perpage
     * @param int $count
     */
    public function __construct($baseUrl, $page, $perpage, $count)
    {
        $this->page = $page;
        $this->perpage = $perpage > 0 ? $perpage :  1;
        $this->count = $count;
        $this->baseUrl = $baseUrl;
        if (strpos($baseUrl, '?') === false) {
            $this->baseUrl = $baseUrl . '?';
        }
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPerpage()
    {
        return $this->perpage;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return string
     */
    public function lastLink()
    {
        $last = ceil($this->count / $this->perpage);
        return $this->link($last, $this->perpage);
    }

    /**
     * @return string
     */
    public function firstLink()
    {
        return $this->link(1, $this->perpage);
    }

    /**
     * @param int $page
     * @param int $perpage
     * @return string
     */
    public function link($page, $perpage)
    {
        $link = $this->baseUrl . 'perpage=' . $perpage;
        $link .= '&page=' . $page;
        return $link;
    }

    /**
     * @param int $listItemsCount
     * @return array
     */
    public function links($listItemsCount)
    {
        $middle = (int) ($listItemsCount / 2);

        $first = $this->page - $middle;
        $first = $first > 1 ? $first : 1;

        $lastListPage = $first + $listItemsCount;
        $lastPage = ceil($this->count / $this->perpage);

        if ($first > 1 && $this->page != 1 && $this->page == $lastPage) {
            $first--;
        }

        $links = [];

        for ($i = $first; ($i < $lastListPage) && ($i <= $lastPage); $i++) {
            $links[$i] = $this->link($i, $this->perpage);
        }

        return $links;
    }
}