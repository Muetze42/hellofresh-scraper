<?php

namespace NormanHuth\HellofreshScraper\Http\Responses;

use NormanHuth\HellofreshScraper\Models\HelloFreshCuisine;

class CuisinesIndexResponse extends AbstractIndexResponse
{
    /**
     * Display a listing of the resource.
     *
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshCuisine>
     */
    public function items(): array
    {
        return array_map(
            fn (array $allergen) => new HelloFreshCuisine($allergen),
            $this->items
        );
    }
}
