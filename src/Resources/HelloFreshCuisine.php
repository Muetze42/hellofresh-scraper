<?php

namespace NormanHuth\HellofreshScraper\Resources;

use NormanHuth\HellofreshScraper\Traits\HasIdTrait;

class HelloFreshCuisine extends AbstractResource
{
    use HasIdTrait;

    /**
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
