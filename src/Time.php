<?php

namespace NormanHuth\HellofreshScraper;

use Carbon\CarbonInterval;

class Time
{
    /**
     * The time string.
     */
    protected ?string $time;

    /**
     * Create a new HelloFreshTime instance.
     */
    public function __construct(?string $time)
    {
        $this->time = $time;
    }

    /**
     * Get the time string.
     *
     * @return string|null
     */
    public function time(): ?string
    {
        return $this->time;
    }

    /**
     * Get the number of minutes equivalent to the time string.
     *
     * @return float|null
     */
    public function minutes(): ?float
    {
        if (is_null($this->time)) {
            return null;
        }

        return CarbonInterval::make($this->time)?->totalMinutes;
    }
}
