<?php

namespace NormanHuth\HellofreshScraper\Http\Concerns;

use NormanHuth\HellofreshScraper\Models\Allergen;
use NormanHuth\HellofreshScraper\Models\Cuisine;
use NormanHuth\HellofreshScraper\Models\Ingredient;
use NormanHuth\HellofreshScraper\Models\Recipe;

trait ShowRequestsTrait
{
    /**
     * @param  string  $id
     * @return \NormanHuth\HellofreshScraper\Models\Allergen
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HellofreshScraper\Exceptions\ClientException
     */
    public function allergen(string $id): Allergen
    {
        return new Allergen($this->request('allergens/' . $id));
    }

    /**
     * @param  string  $id
     * @return \NormanHuth\HellofreshScraper\Models\Cuisine
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HellofreshScraper\Exceptions\ClientException
     */
    public function cuisine(string $id): Cuisine
    {
        return new Cuisine($this->request('cuisines/' . $id));
    }

    /**
     * @param  string  $id
     * @return \NormanHuth\HellofreshScraper\Models\Ingredient
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HellofreshScraper\Exceptions\ClientException
     */
    public function ingredient(string $id): Ingredient
    {
        return new Ingredient($this->request('ingredients/' . $id));
    }

    /**
     * @param  string  $id
     * @return \NormanHuth\HellofreshScraper\Models\Recipe
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HellofreshScraper\Exceptions\ClientException
     */
    public function recipe(string $id): Recipe
    {
        return new Recipe($this->request('recipes/' . $id));
    }
}
