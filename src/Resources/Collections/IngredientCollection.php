<?php

namespace NormanHuth\HellofreshScraper\Resources\Collections;

use Illuminate\Support\Arr;
use NormanHuth\HellofreshScraper\Resources\IngredientResource;

class IngredientCollection extends AbstractCollection
{
    /**
     * Display a listing of the resource.
     *
     * @return array<int, \NormanHuth\HellofreshScraper\Resources\IngredientResource>
     */
    public function items(): array
    {
        return Arr::map(
            $this->resources,
            fn (array $allergen) => new IngredientResource($allergen)
        );
    }
}
