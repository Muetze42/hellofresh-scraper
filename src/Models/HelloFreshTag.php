<?php

namespace NormanHuth\HellofreshScraper\Models;

class HelloFreshTag extends AbstractModel
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
