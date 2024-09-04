<?php

namespace NormanHuth\HellofreshScraper\Resources;

use NormanHuth\HellofreshScraper\Traits\HasIdTrait;

class HelloFreshTag extends AbstractResource
{
    use HasIdTrait;

    /**
     * @return array{
     *      id: string,
     *      type: string,
     *      name: string,
     *      slug: string,
     *      colorHandle: string,
     *      preferences: array,
     *      displayLabel: bool,
     * }
     */
    public function data(): array
    {
        return $this->data;
    }
}
