<?php

namespace NormanHuth\HelloFreshScraper\Models\Concerns;

use Illuminate\Support\Carbon;

trait HasTimestampsTrait
{
    /**
     * Get the `createdAt` column as parsed datetime attribute.
     *
     * @return \Illuminate\Support\Carbon|null
     */
    public function createdAt(): ?Carbon
    {
        return $this->toDateTime('createdAt');
    }

    /**
     * Get the `updatedAt` column as parsed datetime attribute.
     *
     * @return \Illuminate\Support\Carbon|null
     */
    public function updatedAt(): ?Carbon
    {
        return $this->toDateTime('createdAt');
    }
}
