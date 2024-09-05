<?php

namespace NormanHuth\HellofreshScraper\Resources;

use NormanHuth\HellofreshScraper\Time;
use NormanHuth\HellofreshScraper\Traits\HasIdTrait;
use NormanHuth\HellofreshScraper\Traits\HasRelationTrait;

class RecipeResource extends AbstractResource
{
    use HasIdTrait;
    use HasRelationTrait;

    /**
     * The data array.
     *
     * @var array{
     *      active: bool,
     *      averageRating: int,
     *      canonical: string|null,
     *      canonicalLink: string|null,
     *      cardLink: string|null,
     *      clonedFrom: string|null,
     *      comment: string|null,
     *      country: string,
     *      createdAt: string,
     *      cuisines: array{array-key, array{
     *          id: string,
     *          type: string,
     *          name: string,
     *          slug: string,
     *          iconLink: string,
     *      }},
     *      description: string,
     *      descriptionHTML: string,
     *      descriptionMarkdown: string,
     *      difficulty: int,
     *      favoritesCount: int,
     *      headline: string,
     *      id: string,
     *      imageLink: string,
     *      imagePath: string,
     *      ingredients: array{array-key, array{
     *          id: string,
     *          uuid: string,
     *          name: string,
     *          type: string,
     *          slug: string,
     *          country: string,
     *          imageLink: string,
     *          imagePath: string,
     *          shipped: bool,
     *          allergens: array<int, string>,
     *          family: array{
     *              id: string,
     *              uuid: string,
     *              name: string,
     *              slug: string,
     *              type: string,
     *              priority: int,
     *              iconLink: string|null,
     *              iconPath: string|null,
     *          }
     *      }},
     *      isAddon: bool,
     *      isComplete: null,
     *      link: string|null,
     *      name: string|null,
     *      nutrition: array{array-key, array{
     *          type: string,
     *          name: string,
     *          amount: int,
     *          unit: string,
     *      }},
     *      promotion: string|null,
     *      ratingsCount: int,
     *      seoDescription: string|null,
     *      seoName: string|null,
     *      servingSize: int,
     *      slug: string,
     *      steps: array{array-key, array{
     *           index: int,
     *           instructions: int,
     *           instructionsHTML: int,
     *           instructionsMarkdown: int,
     *           ingredients: array<int, string>,
     *           utensils: array<int, string>,
     *           timers: array<int, string>,
     *           images: array{array-key, array{
     *               link: string,
     *               path: string,
     *               caption: string,
     *           }},
     *           videos: array{array-key, array{
     *               link: string,
     *               path: string,
     *               caption: string,
     *           }},
     *       }},
     *      tags: array{array-key, array{
     *          id: string,
     *          type: string,
     *          name: string,
     *          slug: string,
     *          colorHandle: string,
     *          preferences: array<int, string>,
     *          displayLabel: bool,
     *      }},
     *      totalTime: string|null,
     *      uniqueRecipeCode: string|null,
     *      updatedAt: string,
     *      uuid: string,
     *      videoLink: string|null,
     *      websiteUrl: string,
     *      utensils: array{array-key, array{
     *          id: string,
     *          type: string,
     *          name: string,
     *      }}
     *  }
     */
    protected array $data;

    /**
     * Get the data array.
     *
     * @return array{
     *       active: bool,
     *       averageRating: int,
     *       canonical: string|null,
     *       canonicalLink: string|null,
     *       cardLink: string|null,
     *       clonedFrom: string|null,
     *       comment: string|null,
     *       country: string,
     *       createdAt: string,
     *       cuisines: array{array-key, array{
     *           id: string,
     *           type: string,
     *           name: string,
     *           slug: string,
     *           iconLink: string,
     *       }},
     *       description: string,
     *       descriptionHTML: string,
     *       descriptionMarkdown: string,
     *       difficulty: int,
     *       favoritesCount: int,
     *       headline: string,
     *       id: string,
     *       imageLink: string,
     *       imagePath: string,
     *       ingredients: array{array-key, array{
     *           id: string,
     *           uuid: string,
     *           name: string,
     *           type: string,
     *           slug: string,
     *           country: string,
     *           imageLink: string,
     *           imagePath: string,
     *           shipped: bool,
     *           allergens: array<int, string>,
     *           family: array{
     *               id: string,
     *               uuid: string,
     *               name: string,
     *               slug: string,
     *               type: string,
     *               priority: int,
     *               iconLink: string|null,
     *               iconPath: string|null,
     *           }
     *       }},
     *       isAddon: bool,
     *       isComplete: null,
     *       link: string|null,
     *       name: string|null,
     *       nutrition: array{array-key, array{
     *           type: string,
     *           name: string,
     *           amount: int,
     *           unit: string,
     *       }},
     *       promotion: string|null,
     *       ratingsCount: int,
     *       seoDescription: string|null,
     *       seoName: string|null,
     *       servingSize: int,
     *       slug: string,
     *       steps: array{array-key, array{
     *            index: int,
     *            instructions: int,
     *            instructionsHTML: int,
     *            instructionsMarkdown: int,
     *            ingredients: array<int, string>,
     *            utensils: array<int, string>,
     *            timers: array<int, string>,
     *            images: array{array-key, array{
     *                link: string,
     *                path: string,
     *                caption: string,
     *            }},
     *            videos: array{array-key, array{
     *                link: string,
     *                path: string,
     *                caption: string,
     *            }},
     *        }},
     *       tags: array{array-key, array{
     *           id: string,
     *           type: string,
     *           name: string,
     *           slug: string,
     *           colorHandle: string,
     *           preferences: array<int, string>,
     *           displayLabel: bool,
     *       }},
     *       totalTime: string|null,
     *       uniqueRecipeCode: string|null,
     *       updatedAt: string,
     *       uuid: string,
     *       videoLink: string|null,
     *       websiteUrl: string,
     *       utensils: array{array-key, array{
     *           id: string,
     *           type: string,
     *           name: string,
     *       }}
     *   }
     */
    public function data(): array
    {
        return $this->data;
    }

    public function active(): bool
    {
        return $this->data['active'];
    }

    public function isAddon(): bool
    {
        return $this->data['isAddon'];
    }

    public function imagePath(): ?string
    {
        return $this->data['imagePath'];
    }

    /**
     * @return list<\NormanHuth\HellofreshScraper\Resources\AllergenResource>
     */
    public function allergens(): array
    {
        return $this->hasMany(AllergenResource::class, 'allergens');
    }

    /**
     * @return list<\NormanHuth\HellofreshScraper\Resources\IngredientResource>
     */
    public function ingredients(): array
    {
        return $this->hasMany(IngredientResource::class, 'ingredients');
    }

    /**
     * @return list<\NormanHuth\HellofreshScraper\Resources\UtensilResource>
     */
    public function utensils(): array
    {
        return $this->hasMany(UtensilResource::class, 'utensils');
    }

    public function prepTime(): Time
    {
        return $this->hasOne(Time::class, 'prepTime');
    }

    public function totalTime(): Time
    {
        return $this->hasOne(Time::class, 'totalTime');
    }

    /**
     * @return list<\NormanHuth\HellofreshScraper\Resources\CuisineResource>
     */
    public function cuisines(): array
    {
        return $this->hasMany(CuisineResource::class, 'cuisines');
    }

    /**
     * @return list<\NormanHuth\HellofreshScraper\Resources\NutritionResource>
     */
    public function nutrition(): array
    {
        return $this->hasMany(NutritionResource::class, 'nutrition');
    }

    public function label(): ?LabelResource
    {
        return $this->hasOne(LabelResource::class, 'label');
    }

    public function category(): ?CategoryResource
    {
        return $this->hasOne(CategoryResource::class, 'category');
    }

    /**
     * @return list<\NormanHuth\HellofreshScraper\Resources\StepResource>
     */
    public function steps(): array
    {
        return $this->hasMany(StepResource::class, 'steps');
    }

    /**
     * @return list<\NormanHuth\HellofreshScraper\Resources\TagResource>
     */
    public function tags(): array
    {
        return $this->hasMany(TagResource::class, 'tags');
    }
}
