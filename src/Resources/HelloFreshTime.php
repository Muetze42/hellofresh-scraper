<?php

namespace NormanHuth\HellofreshScraper\Resources;

class HelloFreshTime
{
    /**
     * The data string.
     */
    protected ?string $data;

    public function __construct(?string $data)
    {
        $this->data = $data;
    }

    public function toString(): ?string
    {
        return $this->data;
    }

    public function toInt(): ?int
    {
        return $this->data ? (int) preg_replace('/\D/', '', $this->data) : null;
    }
}
