<?php

namespace NormanHuth\HellofreshScraper\Models;

use Illuminate\Support\Collection;
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
        return $this->hasOne('family');
    }

    /**
     * @return \Illuminate\Support\Collection<array-key, \NormanHuth\HellofreshScraper\Models\Allergen>
     */
    public function allergens(): Collection
    {
        return $this->hasMany('family');
    }
}
