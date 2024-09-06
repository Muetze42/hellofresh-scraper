<?php

namespace NormanHuth\HellofreshScraper\Concerns;

use Illuminate\Support\Collection;

trait HasAllergensTrait
{
    /**
     * @return \Illuminate\Support\Collection<int, \NormanHuth\HellofreshScraper\Models\Allergen>
     */
    public function allergens(): Collection
    {
        return $this->hasMany('allergens');
    }
}
