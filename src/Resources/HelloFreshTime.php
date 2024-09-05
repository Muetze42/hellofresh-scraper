<?php

namespace NormanHuth\HellofreshScraper\Resources;

use Carbon\CarbonInterval;

class HelloFreshTime
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
     * @return int|null
     */
    public function minutes(): ?int
    {
        if (is_null($this->time)) {
            return null;
        }

        return CarbonInterval::make($this->time)->totalMinutes;
    }
}
