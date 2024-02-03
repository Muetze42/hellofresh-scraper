<?php

namespace NormanHuth\HellofreshScraper\Models;

trait HasIdTrait
{
    /**
     * Get the value of the model's primary key.
     */
    public function getKey(): string
    {
        return $this->data['id'];
    }
}
