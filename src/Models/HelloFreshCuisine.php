<?php

namespace NormanHuth\HellofreshScraper\Models;

class HelloFreshCuisine extends AbstractModel
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
