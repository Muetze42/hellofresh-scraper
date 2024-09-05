<?php

namespace NormanHuth\HellofreshScraper\Resources\Collections;

use Illuminate\Support\Arr;
use NormanHuth\HellofreshScraper\Resources\CuisineResource;

class CuisineCollection extends AbstractCollection
{
    /**
     * Display a listing of the resource.
     *
     * @return list<\NormanHuth\HellofreshScraper\Resources\CuisineResource>
     */
    public function items(): array
    {
        return Arr::map(
            $this->resources,
            fn (array $allergen) => new CuisineResource($allergen)
        );
    }
}
