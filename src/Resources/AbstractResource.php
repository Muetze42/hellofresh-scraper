<?php

namespace NormanHuth\HellofreshScraper\Resources;

abstract class AbstractResource
{
    /**
     * The data array.
     */
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    abstract public function data(): array;
}
