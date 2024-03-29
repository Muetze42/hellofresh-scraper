<?php

namespace NormanHuth\HellofreshScraper\Models;

class HelloFreshRecipeYield
{
    use HasRelationTrait;

    /**
     * The data array.
     */
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function yields(): int
    {
        return $this->data['yields'];
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshYieldIngredient>
     */
    public function yieldIngredients(): array
    {
        return $this->hasMany(HelloFreshYieldIngredient::class, 'ingredients');
    }
}
