<?php

namespace NormanHuth\HellofreshScraper\Concerns;

trait HasPrimaryKeyTrait
{
    /**
     * Get the value of the model's primary key.
     *
     * @phpstan-return string
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->getAttribute($this->primaryKey);
    }
}
