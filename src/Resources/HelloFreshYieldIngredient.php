<?php

namespace NormanHuth\HellofreshScraper\Resources;

class HelloFreshYieldIngredient extends AbstractResource
{
    /**
     * @return array{
     *      id: string,
     *      amount: int,
     *      unit: string,
     * }
     */
    public function data(): array
    {
        return $this->data;
    }
}
