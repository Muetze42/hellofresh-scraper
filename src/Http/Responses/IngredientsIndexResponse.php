<?php

namespace NormanHuth\HellofreshScraper\Http\Responses;

use NormanHuth\HellofreshScraper\Models\HelloFreshIngredient;

class IngredientsIndexResponse extends AbstractIndexResponse
{
    /**
     * Display a listing of the resource.
     *
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshIngredient>
     */
    public function items(): array
    {
        return array_map(
            fn (array $allergen) => new HelloFreshIngredient($allergen),
            $this->items
        );
    }
}
