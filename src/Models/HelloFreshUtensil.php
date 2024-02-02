<?php

namespace NormanHuth\HellofreshScraper\Models;

class HelloFreshUtensil extends AbstractModel
{
    use HasIdTrait;

    /**
     * @return array{
     *      id: string,
     *      type: string,
     *      name: string,
     */
    public function data(): array
    {
        return $this->data;
    }
}
