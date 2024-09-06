<?php

namespace NormanHuth\HelloFreshScraper\Models;

class YieldsItem extends AbstractModel
{
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'yields' => 'int',
    ];

    /**
     * Get all the current attributes on the model.
     *
     * @phpstan-return array<string, mixed>
     *
     * @return array{
     *     yields: int,
     *     ingredients: array{array-key, array{
     *         id: string,
     *         amount: int,
     *          unit: string
     *     }},
     *  }
     */
    public function getAttributes(): array
    {
        return parent::getAttributes();
    }
}
