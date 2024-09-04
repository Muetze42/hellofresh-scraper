<?php

namespace NormanHuth\HellofreshScraper\Resources;

use NormanHuth\HellofreshScraper\Traits\HasIdTrait;

class HelloFreshCategory extends AbstractResource
{
    use HasIdTrait;

    /**
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
