<?php

namespace NormanHuth\HellofreshScraper\Models;

use NormanHuth\HellofreshScraper\Concerns\HasPrimaryKeyTrait;

class Tag extends AbstractModel
{
    use HasPrimaryKeyTrait;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'displayLabel' => 'bool',
    ];

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
     *     colorHandle: string,
     *     preferences: string[],
     *     displayLabel: bool,
     * }
     */
    public function getAttributes(): array
    {
        return parent::getAttributes();
    }
}
