<?php

namespace NormanHuth\HelloFreshScraper\Models\Concerns;

trait HasNameTrait
{
    /**
     * Get the name attribute.
     */
    public function name(): string
    {
        return $this->toString('name');
    }
}
