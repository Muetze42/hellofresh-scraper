<?php

namespace NormanHuth\HellofreshScraper\Resources;

class YieldIngredientResource extends AbstractResource
{
    /**
     * The data array.
     *
     * @var array{
     *       id: string,
     *       amount: int,
     *       unit: string,
     *  }
     */
    protected array $data;

    /**
     * Get the data array.
     *
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
