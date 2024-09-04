<?php

namespace NormanHuth\HellofreshScraper\Resources;

class HelloFreshNutrition extends AbstractResource
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
