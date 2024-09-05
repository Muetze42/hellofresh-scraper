<?php

namespace NormanHuth\HellofreshScraper\Resources;

abstract class AbstractResource
{
    /**
     * The data array.
     *
     * @var array<string, mixed>
     */
    protected array $data;

    /**
     * @param  array<string, mixed>  $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the data array.
     *
     * @return array<string, mixed>
     */
    abstract public function data(): array;
}
