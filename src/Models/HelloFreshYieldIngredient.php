<?php

namespace NormanHuth\HellofreshScraper\Models;

class HelloFreshYieldIngredient extends AbstractModel
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
