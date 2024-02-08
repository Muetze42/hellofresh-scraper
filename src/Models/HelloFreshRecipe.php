<?php

namespace NormanHuth\HellofreshScraper\Models;

use Illuminate\Support\Arr;

class HelloFreshRecipe extends AbstractModel
{
    use HasIdTrait;
    use HasRelationTrait;

    /**
     * @return array{
     *      active: bool,
     *      averageRating: int,
     *      canonical: string|null,
     *      canonicalLink: string|null,
     *      cardLink: string|null,
     *      clonedFrom: string|null,
     *      comment: string|null,
     *      country: string,
     *      createdAt: string,
     *      cuisines: array,
     *      description: array,
     *      descriptionHTML: array,
     *      descriptionMarkdown: array,
     *      difficulty: int,
     *      favoritesCount: int,
     *      headline: string,
     *      id: string,
     *      imageLink: string,
     *      imagePath: string,
     *      isAddon: bool,
     *      isComplete: null,
     *      link: null,
     *      name: null,
     *      promotion: string|null,
     *      ratingsCount: int,
     *      seoDescription: string|null,
     *      seoName: string|null,
     *      servingSize: int,
     *      slug: string,
     *      uniqueRecipeCode: string,
     *      updatedAt: string,
     *      uuid: string,
     *      videoLink: string|null,
     *      websiteUrl: string,
     * }
     */
    public function data(): array
    {
        return Arr::except($this->data, [
            'allergens',
            'category',
            'cuisines',
            'ingredients',
            'label',
            //'nutrition',
            //'prepTime',
            //'steps',
            'tags',
            //'totalTime',
            'utensils',
        ]);
    }

    public function active(): bool
    {
        return (bool) $this->data['active'];
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshAllergen>
     */
    public function allergens(): array
    {
        return $this->hasMany(HelloFreshAllergen::class, 'allergens');
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshIngredient>
     */
    public function ingredients(): array
    {
        return $this->hasMany(HelloFreshIngredient::class, 'ingredients');
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshUtensil>
     */
    public function utensils(): array
    {
        return $this->hasMany(HelloFreshUtensil::class, 'utensils');
    }

    public function prepTime(): HelloFreshTime
    {
        return $this->hasOne(HelloFreshTime::class, 'prepTime');
    }

    public function totalTime(): HelloFreshTime
    {
        return $this->hasOne(HelloFreshTime::class, 'totalTime');
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshCuisine>
     */
    public function cuisines(): array
    {
        return $this->hasMany(HelloFreshCuisine::class, 'cuisines');
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshNutrition>
     */
    public function nutrition(): array
    {
        return $this->hasMany(HelloFreshNutrition::class, 'nutrition');
    }

    public function label(): ?HelloFreshLabel
    {
        return $this->hasOne(HelloFreshLabel::class, 'label');
    }

    public function category(): ?HelloFreshCategory
    {
        return $this->hasOne(HelloFreshCategory::class, 'category');
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshStep>
     */
    public function steps(): array
    {
        return $this->hasMany(HelloFreshStep::class, 'steps');
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshTag>
     */
    public function tags(): array
    {
        return $this->hasMany(HelloFreshTag::class, 'tags');
    }
}
