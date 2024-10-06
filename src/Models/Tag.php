<?php

namespace NormanHuth\HelloFreshScraper\Models;

use NormanHuth\HelloFreshScraper\Models\Concerns\HasNameTrait;
use NormanHuth\HelloFreshScraper\Models\Concerns\HasPrimaryKeyTrait;

class Tag extends AbstractModel
{
    use HasPrimaryKeyTrait;
    use HasNameTrait;

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

    /**
     * Determine if this recipe is active.
     */
    public function active(): bool
    {
        return $this->toBool('displayLabel');
    }
}
