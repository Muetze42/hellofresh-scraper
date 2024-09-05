<?php

namespace NormanHuth\HellofreshScraper\Resources;

use NormanHuth\HellofreshScraper\Traits\HasRelationTrait;

class RecipeYieldResource extends AbstractResource
{
    use HasRelationTrait;

    /**
     * The data array.
     *
     * @var array{yields: int, ingredients: array{
     *     id: string,
     *     amount: string,
     *     unit: string,
     * }}
     */
    protected array $data;

    public function yields(): int
    {
        return $this->data['yields'];
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Resources\YieldIngredientResource>
     */
    public function yieldIngredients(): array
    {
        return $this->hasMany(YieldIngredientResource::class, 'ingredients');
    }

    /**
     * Get the data array.
     *
     * @return array{yields: int, ingredients: array{
     *      id: string,
     *      amount: string,
     *      unit: string,
     *  }}
     */
    public function data(): array
    {
        return $this->data;
    }
}
