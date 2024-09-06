<?php

namespace NormanHuth\HellofreshScraper\Models\Concerns;

use Illuminate\Support\Collection;

trait HasAllergensTrait
{
    /**
     * @return \Illuminate\Support\Collection<array-key, \NormanHuth\HellofreshScraper\Models\Allergen>
     */
    public function allergens(): Collection
    {
        return $this->hasMany('allergens');
    }
}
