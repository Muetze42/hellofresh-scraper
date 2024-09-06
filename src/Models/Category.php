<?php

namespace NormanHuth\HellofreshScraper\Models;

use NormanHuth\HellofreshScraper\Models\Concerns\HasPrimaryKeyTrait;

class Category extends AbstractModel
{
    use HasPrimaryKeyTrait;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'priority' => 'int',
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
     *     slug: string
     * }
     */
    public function getAttributes(): array
    {
        return parent::getAttributes();
    }
}
