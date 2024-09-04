<?php

namespace NormanHuth\HellofreshScraper\Resources;

class HelloFreshLabel extends AbstractResource
{
    /**
     * @return array{
     *      text: string,
     *      handle: string,
     *      foregroundColor: string,
     *      backgroundColor: string,
     *      displayLabel: false,
     * }
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * Get the value of the resource primary key.
     */
    public function getKey(): string
    {
        return $this->data['handle'];
    }
}
