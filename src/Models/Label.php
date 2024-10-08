<?php

namespace NormanHuth\HelloFreshScraper\Models;

use NormanHuth\HelloFreshScraper\Models\Concerns\HasPrimaryKeyTrait;

class Label extends AbstractModel
{
    use HasPrimaryKeyTrait;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected string $primaryKey = 'handle';

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
     *     text: string,
     *     handle: string,
     *     foregroundColor: string,
     *     backgroundColor: string,
     *     displayLabel: bool
     * }
     */
    public function getAttributes(): array
    {
        return parent::getAttributes();
    }

    /**
     * Determine if this label should display.
     */
    public function displayLabel(): bool
    {
        return $this->toBool('displayLabel');
    }
}
