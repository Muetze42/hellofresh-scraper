<?php

namespace NormanHuth\HellofreshScraper\Resources;

use NormanHuth\HellofreshScraper\Traits\HasIdTrait;

class CuisineResource extends AbstractResource
{
    use HasIdTrait;

    /**
     * The data array.
     *
     * @var array{
     *     id: string,
     *     type: string,
     *     name: string,
     *     slug: string,
     *     iconLink: string
     * }
     */
    protected array $data;

    /**
     * Get the data array.
     *
     * @return array{
     *      id: string,
     *      type: string,
     *      name: string,
     *      slug: string,
     *      iconLink: string,
     * }
     */
    public function data(): array
    {
        return $this->data;
    }
}
