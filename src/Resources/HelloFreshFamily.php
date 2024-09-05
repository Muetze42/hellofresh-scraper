<?php

namespace NormanHuth\HellofreshScraper\Resources;

use NormanHuth\HellofreshScraper\Traits\HasIdTrait;

class HelloFreshFamily extends AbstractResource
{
    use HasIdTrait;

    /**
     * The data array.
     *
     * @var array{
     *     id: string,
     *     uuid: string,
     *     name: string,
     *     slug: string,
     *     type: string,
     *     priority: int,
     *     iconLink: string|null,
     *     iconPath: string|null,
     * }
     */
    protected array $data;

    /**
     * Get the data array.
     *
     * @return array{
     *      id: string,
     *      uuid: string,
     *      name: string,
     *      slug: string,
     *      type: string,
     *      priority: int,
     *      iconLink: string|null,
     *      iconPath: string|null,
     * }
     */
    public function data(): array
    {
        return $this->data;
    }
}
