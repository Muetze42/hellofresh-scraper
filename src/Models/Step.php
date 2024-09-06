<?php

namespace NormanHuth\HelloFreshScraper\Models;

class Step extends AbstractModel
{
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'index' => 'int',
    ];

    /**
     * Get all the current attributes on the model.
     *
     * @phpstan-return array<string, mixed>
     *
     * @return array{
     *     index: int,
     *     instructions: string,
     *     instructionsHTML: string,
     *     instructionsMarkdown: string,
     *     ingredients: string[],
     *     utensils: string[],
     *     timers: string[],
     *     images: array<array-key, array<string, string>>,
     *     videos: array<array-key, array<string, string>>,
     *  }
     */
    public function getAttributes(): array
    {
        return parent::getAttributes();
    }
}
