<?php

namespace NormanHuth\HellofreshScraper\Resources;

use NormanHuth\HellofreshScraper\Traits\HasIdTrait;

class CategoryResource extends AbstractResource
{
    use HasIdTrait;

    /**
     * The data array.
     *
     * @var array{
     *     id: string,
     *     name: string,
     *     type: string,
     *     slug: string,
     * }
     */
    protected array $data;

    /**
     * Get the data array.
     *
     * @return array{
     *      id: string,
     *      name: string,
     *      type: string,
     *      slug: string,
     * }
     */
    public function data(): array
    {
        return $this->data;
    }
}
