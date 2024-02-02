<?php

namespace NormanHuth\HellofreshScraper\Models;

class HelloFreshAllergen extends AbstractModel
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
