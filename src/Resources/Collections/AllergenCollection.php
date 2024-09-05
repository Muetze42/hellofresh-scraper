<?php

namespace NormanHuth\HellofreshScraper\Resources\Collections;

use Illuminate\Support\Arr;
use NormanHuth\HellofreshScraper\Resources\AllergenResource;

class AllergenCollection extends AbstractCollection
{
    /**
     * Display a listing of the resource.
     *
     * @return array<int, \NormanHuth\HellofreshScraper\Resources\AllergenResource>
     */
    public function items(): array
    {
        return Arr::map(
            $this->resources,
            fn (array $allergen) => new AllergenResource($allergen)
        );
    }
}
