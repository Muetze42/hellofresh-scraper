<?php

namespace NormanHuth\HellofreshScraper\Models;

class HelloFreshStepImage
{
    /**
     * The data array.
     */
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array{
     *      link: string,
     *      path: string,
     *      caption: string,
     * }
     */
    public function data(): array
    {
        return $this->data;
    }
}
