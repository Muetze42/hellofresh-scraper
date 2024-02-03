<?php

namespace NormanHuth\HellofreshScraper\Models;

use Illuminate\Support\Arr;

class HelloFreshIngredient extends AbstractModel
{
    use HasIdTrait;
    use HasRelationTrait;

    /**
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

    public function family(): HelloFreshFamily
    {
        return $this->hasOne(HelloFreshFamily::class, 'family');
    }
}
