<?php

namespace NormanHuth\HellofreshScraper\Http\Responses;

use NormanHuth\HellofreshScraper\Resources\HelloFreshRecipe;

class RecipesIndexResponse extends AbstractIndexResponse
{
    /**
     * Display a listing of the resource.
     *
     * @return array<\NormanHuth\HellofreshScraper\Resources\HelloFreshRecipe>
     */
    public function items(): array
    {
        return array_map(
            fn (array $recipe) => new HelloFreshRecipe($recipe),
            $this->items
        );
    }
}
