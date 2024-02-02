<?php

namespace NormanHuth\HellofreshScraper\Models;

use Illuminate\Support\Arr;

class HelloFreshRecipe extends AbstractModel
{
    use HasIdTrait;

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
            'nutrition',
            'prepTime',
            'steps',
            'tags',
            'totalTime',
            'utensils',
        ]);
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshAllergen>
     */
    public function allergens(): array
    {
        return array_map(
            fn (array $allergen) => new HelloFreshAllergen($allergen),
            $this->data['allergens']
        );
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshIngredient>
     */
    public function ingredients(): array
    {
        return array_map(
            fn (array $ingredient) => new HelloFreshIngredient($ingredient),
            $this->data['ingredients']
        );
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshUtensil>
     */
    public function utensils(): array
    {
        return array_map(
            fn (array $ingredient) => new HelloFreshUtensil($ingredient),
            $this->data['utensils']
        );
    }

    public function category(): HelloFreshCategory
    {
        return new HelloFreshCategory($this->data['category']);
    }

    public function prepTime(): HelloFreshTime
    {
        return new HelloFreshTime($this->data['prepTime']);
    }

    public function totalTime(): HelloFreshTime
    {
        return new HelloFreshTime($this->data['totalTime']);
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshCuisine>
     */
    public function cuisines(): array
    {
        return array_map(
            fn (array $cuisine) => new HelloFreshCuisine($cuisine),
            $this->data['cuisines']
        );
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshNutrition>
     */
    public function nutrition(): array
    {
        return array_map(
            fn (array $cuisine) => new HelloFreshNutrition($cuisine),
            $this->data['nutrition']
        );
    }

    public function label(): ?HelloFreshLabel
    {
        if ($label = $this->data['label']) {
            return new HelloFreshLabel($label);
        }

        return null;
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshStep>
     */
    public function steps(): array
    {
        return array_map(
            fn (array $step) => new HelloFreshStep($step),
            $this->data['steps']
        );
    }

    /**
     * @return array<\NormanHuth\HellofreshScraper\Models\HelloFreshTag>
     */
    public function tags(): array
    {
        return array_map(
            fn (array $cuisine) => new HelloFreshTag($cuisine),
            $this->data['tags']
        );
    }
}
