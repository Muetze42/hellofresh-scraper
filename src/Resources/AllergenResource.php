<?php

namespace NormanHuth\HellofreshScraper\Resources;

use NormanHuth\HellofreshScraper\Traits\HasIdTrait;

class AllergenResource extends AbstractResource
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
     *     iconLink: string,
     *     iconPath: string,
     *     triggersTracesOf: bool,
     *     tracesOf: bool,
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
     *      iconLink: string,
     *      iconPath: string,
     *      triggersTracesOf: bool,
     *      tracesOf: bool,
     * }
     */
    public function data(): array
    {
        return $this->data;
    }
}
