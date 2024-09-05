<?php

namespace NormanHuth\HellofreshScraper\Resources;

class LabelResource extends AbstractResource
{
    /**
     * The data array.
     *
     * @var array{
     *     text: string,
     *     handle: string,
     *     foregroundColor: string,
     *     backgroundColor: string,
     *     displayLabel: false,
     * }
     */
    protected array $data;

    /**
     * Get the data array.
     *
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
