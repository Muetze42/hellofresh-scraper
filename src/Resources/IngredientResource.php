<?php

namespace NormanHuth\HellofreshScraper\Resources;

use Illuminate\Support\Arr;
use NormanHuth\HellofreshScraper\Traits\HasIdTrait;
use NormanHuth\HellofreshScraper\Traits\HasRelationTrait;

class IngredientResource extends AbstractResource
{
    use HasIdTrait;
    use HasRelationTrait;

    /**
     * The data array.
     *
     * @var array{
     *     id: string,
     *     uuid: string,
     *     name: string,
     *     type: string,
     *     slug: string,
     *     country: string,
     *     imageLink: string,
     *     imagePath: string,
     *     shipped: bool,
     *     description: string|null,
     *     usage: int,
     *     hasDuplicatedName: null,
     *     allergens: array{array-key, array{
     *         id: string,
     *         name: string,
     *         type: string,
     *         slug: string,
     *         description: string|null,
     *         iconPath: string|null,
     *         triggersTracesOf: bool,
     *         tracesOf: bool,
     *         usage: int,
     *     }},
     *     family: array{
     *         id: string,
     *         uuid: string,
     *         name: string,
     *         slug: string,
     *         type: string,
     *         description: string|null,
     *         priority: int,
     *         iconLink: string,
     *         iconPath: string,
     *         usageByCountry: array<string, int>,
     *         createdAt: string,
     *         updatedAt: string,
     *     },
     *  }
     */
    protected array $data;

    /**
     * Get the data array.
     *
     * @return array{
     *      id: string,
     *      uuid: string,
     *      name: string,
     *      type: string,
     *      slug: string,
     *      country: string,
     *      imageLink: string,
     *      imagePath: string,
     *      shipped: bool,
     *      description: string|null,
     *      usage: int,
     *      hasDuplicatedName: null,
     *      allergens: array{array-key, array{
     *          id: string,
     *          name: string,
     *          type: string,
     *          slug: string,
     *          description: string|null,
     *          iconPath: string|null,
     *          triggersTracesOf: bool,
     *          tracesOf: bool,
     *          usage: int,
     *      }},
     *      family: array{
     *          id: string,
     *          uuid: string,
     *          name: string,
     *          slug: string,
     *          type: string,
     *          description: string|null,
     *          priority: int,
     *          iconLink: string,
     *          iconPath: string,
     *          usageByCountry: array<string, int>,
     *          createdAt: string,
     *          updatedAt: string,
     *      },
     *   }
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * Return an array of allergen IDs.
     *
     * @return array{array-key, array{
     *           id: string,
     *           name: string,
     *           type: string,
     *           slug: string,
     *           description: string|null,
     *           iconPath: string|null,
     *           triggersTracesOf: bool,
     *           tracesOf: bool,
     *           usage: int,
     *       }}
     */
    public function allergensIds(): array
    {
        return $this->data['allergens'];
    }

    public function family(): ?FamilyResource
    {
        return $this->hasOne(FamilyResource::class, 'family');
    }
}
