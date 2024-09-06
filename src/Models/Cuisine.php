<?php

namespace NormanHuth\HellofreshScraper\Models;

use NormanHuth\HellofreshScraper\Models\Concerns\HasPrimaryKeyTrait;

class Cuisine extends AbstractModel
{
    use HasPrimaryKeyTrait;

    /**
     * Get all the current attributes on the model.
     *
     * @phpstan-return array<string, mixed>
     *
     * @return array{
     *     id: string,
     *     type: string,
     *     name: string,
     *     slug: string,
     *     usage: int,
     *     iconLink: string,
     *     iconPath: string
     * }
     */
    public function getAttributes(): array
    {
        return parent::getAttributes();
    }
}