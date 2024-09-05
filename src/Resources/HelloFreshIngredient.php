<?php

namespace NormanHuth\HellofreshScraper\Resources;

use Illuminate\Support\Arr;
use NormanHuth\HellofreshScraper\Traits\HasIdTrait;
use NormanHuth\HellofreshScraper\Traits\HasRelationTrait;

class HelloFreshIngredient extends AbstractResource
{
    use HasIdTrait;
    use HasRelationTrait;

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
     * }
     */
    public function data(): array
    {
        return Arr::except($this->data, ['allergens', 'family']);
    }

    /**
     * Return an array of allergen IDs.
     */
    public function allergensIds(): array
    {
        return $this->data['allergens'];
    }

    public function family(): ?HelloFreshFamily
    {
        return $this->hasOne(HelloFreshFamily::class, 'family');
    }
}
