<?php

namespace NormanHuth\HellofreshScraper\Models;

use Illuminate\Support\Collection;
use NormanHuth\HellofreshScraper\Concerns\HasAllergensTrait;
use NormanHuth\HellofreshScraper\Concerns\HasPrimaryKeyTrait;

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
     *     allergens: array,
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
     *     nutrition: array,
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

    /**
     * @return \NormanHuth\HellofreshScraper\Models\Category|null
     */
    public function category(): ?Category
    {
        $attribute = $this->getAttribute('category');

        if (! is_array($attribute) || empty($attribute)) {
            return null;
        }

        return new Category($attribute);
    }

    /**
     * @return \NormanHuth\HellofreshScraper\Models\Label|null
     */
    public function label(): ?Label
    {
        $attribute = $this->getAttribute('label');

        if (! is_array($attribute) || empty($attribute)) {
            return null;
        }

        return new Label($attribute);
    }

    /**
     * @return \Illuminate\Support\Collection<int, \NormanHuth\HellofreshScraper\Models\Cuisine>
     */
    public function cuisines(): Collection
    {
        $attribute = $this->getAttribute('cuisines');

        if (! is_array($attribute) || empty($attribute)) {
            return collect();
        }

        return collect(array_map(
            fn ($allergen) => new Cuisine($allergen),
            $attribute
        ));
    }

    /**
     * @return \Illuminate\Support\Collection<int, \NormanHuth\HellofreshScraper\Models\Ingredient>
     */
    public function ingredients(): Collection
    {
        $attribute = $this->getAttribute('ingredients');

        if (! is_array($attribute) || empty($attribute)) {
            return collect();
        }

        return collect(array_map(
            fn ($allergen) => new Ingredient($allergen),
            $attribute
        ));
    }

    /**
     * @return \Illuminate\Support\Collection<int, \NormanHuth\HellofreshScraper\Models\Nutrition>
     */
    public function nutrition(): Collection
    {
        $attribute = $this->getAttribute('nutrition');

        if (! is_array($attribute) || empty($attribute)) {
            return collect();
        }

        return collect(array_map(
            fn ($allergen) => new Nutrition($allergen),
            $attribute
        ));
    }

    /**
     * @return \Illuminate\Support\Collection<int, \NormanHuth\HellofreshScraper\Models\Step>
     */
    public function steps(): Collection
    {
        $attribute = $this->getAttribute('steps');

        if (! is_array($attribute) || empty($attribute)) {
            return collect();
        }

        return collect(array_map(
            fn ($allergen) => new Step($allergen),
            $attribute
        ));
    }

    /**
     * @return \Illuminate\Support\Collection<int, \NormanHuth\HellofreshScraper\Models\Tag>
     */
    public function tags(): Collection
    {
        $attribute = $this->getAttribute('tags');

        if (! is_array($attribute) || empty($attribute)) {
            return collect();
        }

        return collect(array_map(
            fn ($allergen) => new Tag($allergen),
            $attribute
        ));
    }

    /**
     * @return \Illuminate\Support\Collection<int, \NormanHuth\HellofreshScraper\Models\YieldsItem>
     */
    public function yields(): Collection
    {
        $attribute = $this->getAttribute('yields');

        if (! is_array($attribute) || empty($attribute)) {
            return collect();
        }

        return collect(array_map(
            fn ($allergen) => new YieldsItem($allergen),
            $attribute
        ));
    }

    /**
     * Get the total time in minutes.
     *
     * @return int|null
     */
    public function totalTime(): ?int
    {
        return $this->toMinutes('totalTime');
    }

    /**
     * Get the prep time in minutes.
     *
     * @return int|null
     */
    public function prepTime(): ?int
    {
        return $this->toMinutes('prepTime');
    }

    /**
     * Determine if this recipe is active.
     *
     * @return bool
     */
    public function active(): bool
    {
        return $this->bool('active');
    }

    /**
     * Determine if this recipe is an Addon.
     *
     * @return bool
     */
    public function isAddon(): bool
    {
        return $this->bool('isAddon');
    }

    /**
     * Determine if this recipe has an image to display.
     *
     * @return bool
     */
    public function hasImage(): bool
    {
        $attribute = $this->getAttribute('imagePath');

        return ! empty($attribute) && is_string($attribute);
    }
}
