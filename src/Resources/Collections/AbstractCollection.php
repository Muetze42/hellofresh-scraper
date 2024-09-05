<?php

namespace NormanHuth\HellofreshScraper\Resources\Collections;

abstract class AbstractCollection
{
    /**
     * The resources array.
     *
     * @var array<int, mixed>
     */
    protected array $resources;

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

    /**
     * @param array{
     *     items: array<int, array<string, mixed>>,
     *     take: int,
     *     skip: int,
     *     count: int,
     *     total: int,
     * }  $data
     */
    public function __construct(array $data)
    {
        $this->resources = $data['items'];
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

        return $next < $this->total ? $next : null;
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
     *
     * @return array<int, object>
     */
    abstract public function items(): array;
}
