<?php

namespace NormanHuth\HelloFreshScraper\Models;

use NormanHuth\HelloFreshScraper\Models\Concerns\HasNameTrait;
use NormanHuth\HelloFreshScraper\Models\Concerns\HasPrimaryKeyTrait;

class Category extends AbstractModel
{
    use HasPrimaryKeyTrait;
    use HasNameTrait;

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
