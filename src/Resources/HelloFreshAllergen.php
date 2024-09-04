<?php

namespace NormanHuth\HellofreshScraper\Resources;

use NormanHuth\HellofreshScraper\Traits\HasIdTrait;

class HelloFreshAllergen extends AbstractResource
{
    use HasIdTrait;

    /**
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
