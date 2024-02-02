<?php

namespace NormanHuth\HellofreshScraper\Models;

abstract class AbstractModel
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
