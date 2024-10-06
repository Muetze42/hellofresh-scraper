<?php

namespace NormanHuth\HelloFreshScraper\Models;

use NormanHuth\HelloFreshScraper\Models\Concerns\HasNameTrait;
use NormanHuth\HelloFreshScraper\Models\Concerns\HasPrimaryKeyTrait;

class Allergen extends AbstractModel
{
    use HasPrimaryKeyTrait;
    use HasNameTrait;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'triggersTracesOf' => 'bool',
        'tracesOf' => 'bool',
        //'description' => 'string', // Always null and not included in recipes
        //'usage' => 'int',  // Not included in recipes
    ];

    /**
     * Get all the current attributes on the model.
     *
     * @phpstan-return array<string, mixed>
     *
     * @return array{
     *     id: string,
     *     name: string,
     *     type: string,
     *     slug: string,
     *     iconPath: string|null,
     *     triggersTracesOf: bool,
     *     tracesOf: bool
     * }
     */
    public function getAttributes(): array
    {
        return parent::getAttributes();
    }
}
