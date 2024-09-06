<?php

namespace NormanHuth\HelloFreshScraper\Models;

use NormanHuth\HelloFreshScraper\Models\Concerns\HasPrimaryKeyTrait;

class Nutrition extends AbstractModel
{
    use HasPrimaryKeyTrait;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected string $primaryKey = 'type';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'int',
    ];

    /**
     * Get all the current attributes on the model.
     *
     * @phpstan-return array<string, mixed>
     *
     * @return array{
     *     type: string,
     *     name: string,
     *     amount: int,
     *     unit: string,
     * }
     */
    public function getAttributes(): array
    {
        return parent::getAttributes();
    }
}
