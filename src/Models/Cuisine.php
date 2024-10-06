<?php

namespace NormanHuth\HelloFreshScraper\Models;

use NormanHuth\HelloFreshScraper\Models\Concerns\HasNameTrait;
use NormanHuth\HelloFreshScraper\Models\Concerns\HasPrimaryKeyTrait;

class Cuisine extends AbstractModel
{
    use HasPrimaryKeyTrait;
    use HasNameTrait;

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
