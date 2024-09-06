<?php

namespace NormanHuth\HelloFreshScraper\Models;

use Illuminate\Support\Collection;
use NormanHuth\HelloFreshScraper\Models\Concerns\HasAllergensTrait;
use NormanHuth\HelloFreshScraper\Models\Concerns\HasPrimaryKeyTrait;

class Recipe extends AbstractModel
{
    use HasAllergensTrait;
    use HasPrimaryKeyTrait;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'bool',
        'isAddon' => 'bool',
        'averageRating' => 'int',
        'difficulty' => 'int',
        'favoritesCount' => 'int',
        'ratingsCount' => 'int',
        'servingSize' => 'int',
    ];

    /**
     * Get all the current attributes on the model.
     *
     * @phpstan-return array<string, mixed>
     *
     * @return array{
     *     active: bool,
     *     allergens: array<string, mixed>|null,
     *     averageRating: int,
     *     canonical: string|null,
     *     canonicalLink: string|null,
     *     cardLink: string|null,
     *     category: array<string, mixed>|null,
     *     clonedFrom: string|null,
     *     comment: string|null,
     *     country: string,
     *     createdAt: string,
     *     cuisines: array<array-key, array<string, mixed>>,
     *     description: string|null,
     *     descriptionHTML: string|null,
     *     descriptionMarkdown: string|null,
     *     difficulty: int,
     *     favoritesCount: int,
     *     headline: string|null,
     *     id: string,
     *     imageLink: string,
     *     imagePath: string,
     *     ingredients: array<array-key, array<string, mixed>>,
     *     isAddon: bool,
     *     isComplete: null,
     *     label: array<string, mixed>,
     *     link: string,
     *     name: string,
     *     nutrition: array<array-key, array<string, mixed>>,
     *     prepTime: string|null,
     *     promotion: string|null,
     *     ratingsCount: int,
     *     seoDescription: string,
     *     seoName: string,
     *     servingSize: int,
     *     slug: string,
     *     steps: array<array-key, array<string, mixed>>,
     *     tags: array<array-key, array<string, mixed>>,
     *     totalTime: string|null,
     *     uniqueRecipeCode: string|null,
     *     updatedAt: string,
     *     utensils: array<array-key, array<string, mixed>>,
     *     uuid: string|null,
     *     videoLink: string|null,
     *     websiteUrl: string,
     *     yields: array<array-key, array<string, mixed>>,
     * }
     */
    public function getAttributes(): array
    {
        return parent::getAttributes();
    }

    public function category(): ?Category
    {
        return $this->hasOne('category');
    }

    /**
     * @return \NormanHuth\HelloFreshScraper\Models\Label|null
     */
    public function label(): ?Label
    {
        return $this->hasOne('label');
    }

    /**
     * @return \Illuminate\Support\Collection<array-key, \NormanHuth\HelloFreshScraper\Models\Cuisine>
     */
    public function cuisines(): Collection
    {
        return $this->hasMany('cuisines');
    }

    /**
     * @return \Illuminate\Support\Collection<array-key, \NormanHuth\HelloFreshScraper\Models\Ingredient>
     */
    public function ingredients(): Collection
    {
        return $this->hasMany('ingredients');
    }

    /**
     * @return \Illuminate\Support\Collection<array-key, \NormanHuth\HelloFreshScraper\Models\Nutrition>
     */
    public function nutrition(): Collection
    {
        return $this->hasMany('nutrition');
    }

    /**
     * @return \Illuminate\Support\Collection<array-key, \NormanHuth\HelloFreshScraper\Models\Step>
     */
    public function steps(): Collection
    {
        return $this->hasMany('steps');
    }

    /**
     * @return \Illuminate\Support\Collection<array-key, \NormanHuth\HelloFreshScraper\Models\Tag>
     */
    public function tags(): Collection
    {
        return $this->hasMany('tags');
    }

    /**
     * @return \Illuminate\Support\Collection<array-key, \NormanHuth\HelloFreshScraper\Models\YieldsItem>
     */
    public function yields(): Collection
    {
        $value = $this->getAttribute('yields');

        if (! is_array($value) || empty($value)) {
            return collect();
        }

        return collect(array_map(
            fn ($allergen) => new YieldsItem($allergen),
            $value
        ));
    }

    /**
     * Get the total time in minutes.
     */
    public function totalTime(): ?int
    {
        return $this->toMinutes('totalTime');
    }

    /**
     * Get the prep time in minutes.
     */
    public function prepTime(): ?int
    {
        return $this->toMinutes('prepTime');
    }

    /**
     * Determine if this recipe is active.
     */
    public function active(): bool
    {
        return $this->bool('active');
    }

    /**
     * Determine if this recipe is an Addon.
     */
    public function isAddon(): bool
    {
        return $this->bool('isAddon');
    }

    /**
     * Determine if this recipe has an image to display.
     */
    public function hasImage(): bool
    {
        $value = $this->getAttribute('imagePath');

        return ! empty($value) && is_string($value);
    }
}
