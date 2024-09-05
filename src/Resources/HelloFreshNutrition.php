<?php

namespace NormanHuth\HellofreshScraper\Resources;

class HelloFreshNutrition extends AbstractResource
{
    /**
     * The data array.
     *
     * @var array{
     *     type: string,
     *     name: string,
     *     amount: int,
     *     unit: string,
     * }
     */
    protected array $data;

    /**
     * Get the data array.
     *
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
