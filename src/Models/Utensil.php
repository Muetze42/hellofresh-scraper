<?php

namespace NormanHuth\HellofreshScraper\Models;

use NormanHuth\HellofreshScraper\Concerns\HasPrimaryKeyTrait;

class Utensil extends AbstractModel
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
     *     name: string
     * }
     */
    public function getAttributes(): array
    {
        return parent::getAttributes();
    }
}
