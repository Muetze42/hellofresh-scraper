<?php

namespace NormanHuth\HellofreshScraper\Models;

class HelloFreshLabel extends AbstractModel
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
}
