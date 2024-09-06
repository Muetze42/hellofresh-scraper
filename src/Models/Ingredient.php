<?php

namespace NormanHuth\HellofreshScraper\Models;

use NormanHuth\HellofreshScraper\Concerns\HasAllergensTrait;
use NormanHuth\HellofreshScraper\Concerns\HasPrimaryKeyTrait;

class Ingredient extends AbstractModel
{
    use HasPrimaryKeyTrait;
    use HasAllergensTrait;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'shipped' => 'bool',
        'usage' => 'int',
    ];

    /**
     * Get all the current attributes on the model.
     *
     * @phpstan-return array<string, mixed>
     *
     * @return array{
     *     id: string,
     *     uuid: string,
     *     slug: string,
     *     type: string,
     *     country: string,
     *     imageLink: string,
     *     imagePath: string,
     *     name: string,
     *     internalName: string,
     *     shipped: bool,
     *     description: string|null,
     *     usage: int,
     *     hasDuplicatedName: null,
     *     allergens: array<array-key, array<string, mixed>>,
     *     family: array<string, mixed>,
     * }
     */
    public function getAttributes(): array
    {
        return parent::getAttributes();
    }

    /**
     * @return \NormanHuth\HellofreshScraper\Models\Family|null
     */
    public function family(): ?Family
    {
        $attribute = $this->getAttribute('family');

        if (! is_array($attribute) || empty($attribute)) {
            return null;
        }

        return new Family($attribute);
    }
}
