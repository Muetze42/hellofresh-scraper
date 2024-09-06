<?php

namespace NormanHuth\HellofreshScraper\Models;

use NormanHuth\HellofreshScraper\Models\Concerns\HasPrimaryKeyTrait;

class Allergen extends AbstractModel
{
    use HasPrimaryKeyTrait;

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
