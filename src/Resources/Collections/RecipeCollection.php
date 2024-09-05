<?php

namespace NormanHuth\HellofreshScraper\Resources\Collections;

use Illuminate\Support\Arr;
use NormanHuth\HellofreshScraper\Resources\RecipeResource;

class RecipeCollection extends AbstractCollection
{
    /**
     * Display a listing of the resource.
     *
     * @return list<\NormanHuth\HellofreshScraper\Resources\RecipeResource>
     */
    public function items(): array
    {
        return Arr::map(
            $this->resources,
            fn (array $allergen) => new RecipeResource($allergen)
        );
    }
}
