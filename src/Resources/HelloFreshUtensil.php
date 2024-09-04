<?php

namespace NormanHuth\HellofreshScraper\Resources;

use NormanHuth\HellofreshScraper\Traits\HasIdTrait;

class HelloFreshUtensil extends AbstractResource
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
