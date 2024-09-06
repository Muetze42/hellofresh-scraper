<?php

namespace NormanHuth\HelloFreshScraper\Models\Concerns;

use Illuminate\Support\Collection;

trait HasAllergensTrait
{
    /**
     * @return \Illuminate\Support\Collection<array-key, \NormanHuth\HelloFreshScraper\Models\Allergen>
     */
    public function allergens(): Collection
    {
        return $this->hasMany('allergens');
    }
}
