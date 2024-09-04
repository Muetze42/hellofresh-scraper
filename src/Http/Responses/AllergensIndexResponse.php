<?php

namespace NormanHuth\HellofreshScraper\Http\Responses;

use NormanHuth\HellofreshScraper\Resources\HelloFreshAllergen;

class AllergensIndexResponse extends AbstractIndexResponse
{
    /**
     * Display a listing of the resource.
     *
     * @return array<\NormanHuth\HellofreshScraper\Resources\HelloFreshAllergen>
     */
    public function items(): array
    {
        return array_map(
            fn (array $allergen) => new HelloFreshAllergen($allergen),
            $this->items
        );
    }
}
