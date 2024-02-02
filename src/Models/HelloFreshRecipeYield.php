<?php

namespace NormanHuth\HellofreshScraper\Models;

class HelloFreshRecipeYield
{
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
        return array_map(
            fn (array $allergen) => new HelloFreshYieldIngredient($allergen),
            $this->data['ingredients']
        );
    }
}
