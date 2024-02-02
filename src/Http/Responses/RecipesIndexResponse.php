<?php

namespace NormanHuth\HellofreshScraper\Http\Responses;

use NormanHuth\HellofreshScraper\Models\HelloFreshRecipe;

class RecipesIndexResponse extends AbstractIndexResponse
{
    /**
     * Display a listing of the resource.
     *
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshRecipe>
     */
    public function items(): array
    {
        return array_map(
            fn (array $recipe) => new HelloFreshRecipe($recipe),
            $this->items
        );
    }
}
