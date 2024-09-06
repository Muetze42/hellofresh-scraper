<?php

namespace NormanHuth\HellofreshScraper\Concerns;

use Illuminate\Support\Collection;
use NormanHuth\HellofreshScraper\Models\Allergen;

trait HasAllergensTrait
{
    /**
     * @return \Illuminate\Support\Collection<int, \NormanHuth\HellofreshScraper\Models\Allergen>
     */
    public function allergens(): Collection
    {
        $value = $this->getAttribute('allergens');

        if (! is_array($value) || empty($value)) {
            return collect();
        }

        return collect(array_map(
            fn ($allergen) => new Allergen($allergen),
            $value
        ));
    }
}
