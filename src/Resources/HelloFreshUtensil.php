<?php

namespace NormanHuth\HellofreshScraper\Resources;

use NormanHuth\HellofreshScraper\Traits\HasIdTrait;

class HelloFreshUtensil extends AbstractResource
{
    use HasIdTrait;

    /**
     * The data array.
     *
     * @var array{
     *     id: string,
     *     type: string,
     *     name: string
     * }
     */
    protected array $data;

    /**
     * Get the data array.
     *
     * @return array{
     *     id: string,
     *     type: string,
     *     name: string
     * }
     */
    public function data(): array
    {
        return $this->data;
    }
}
