<?php

namespace NormanHuth\HellofreshScraper\Models;

trait HasIdTrait
{
    /**
     * Get the value of the model's primary key.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->data['id'];
    }
}
