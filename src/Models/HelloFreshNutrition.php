<?php

namespace NormanHuth\HellofreshScraper\Models;

class HelloFreshNutrition extends AbstractModel
{
    /**
     * @return array{
     *      type: string,
     *      name: string,
     *      amount: int,
     *      unit: string,
     * }
     */
    public function data(): array
    {
        return $this->data;
    }
}
