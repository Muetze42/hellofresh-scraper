<?php

namespace NormanHuth\HellofreshScraper\Traits;

trait HasIdTrait
{
    /**
     * Get the value of the resource primary key.
     */
    public function getKey(): string
    {
        return $this->data['id'];
    }
}
