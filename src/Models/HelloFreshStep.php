<?php

namespace NormanHuth\HellofreshScraper\Models;

class HelloFreshStep
{
    /**
     * The data array.
     */
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function index(): int
    {
        return $this->data['index'];
    }

    public function instructions(): string
    {
        return $this->data['instructions'];
    }

    public function ingredientsIds(): array
    {
        return $this->data['instructions'];
    }

    public function utensilsIds(): array
    {
        return $this->data['instructions'];
    }

    // timers
    // videos
}
