<?php

namespace NormanHuth\HellofreshScraper\Http\Responses;

abstract class AbstractIndexResponse
{
    /**
     * The items array;.
     */
    protected array $items;

    /**
     * The take integer.
     */
    protected int $take;

    /**
     * The skip integer.
     */
    protected int $skip;

    /**
     * The count integer.
     */
    protected int $count;

    /**
     * The total integer.
     */
    protected int $total;

    public function __construct(array $data)
    {
        $this->items = $data['items'];
        $this->take = $data['take'];
        $this->skip = $data['skip'];
        $this->count = $data['count'];
        $this->total = $data['total'];
    }

    /**
     * Get skip value for next page.
     */
    public function getNextPaginate(): ?int
    {
        $next = $this->skip + $this->take;

        return count($this->items) && $next < $this->total ? $next : null;
    }

    public function take(): int
    {
        return $this->take;
    }

    public function skip(): int
    {
        return $this->skip;
    }

    /**
     * Display a listing of the resource.
     */
    abstract public function items(): array;
}
