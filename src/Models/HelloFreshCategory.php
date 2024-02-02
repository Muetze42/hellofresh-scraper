<?php

namespace NormanHuth\HellofreshScraper\Models;

class HelloFreshCategory extends AbstractModel
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
