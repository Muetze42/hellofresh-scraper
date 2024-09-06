<?php

namespace NormanHuth\HelloFreshScraper\Http\Concerns;

use NormanHuth\HelloFreshScraper\Models\Allergen;
use NormanHuth\HelloFreshScraper\Models\Cuisine;
use NormanHuth\HelloFreshScraper\Models\Ingredient;
use NormanHuth\HelloFreshScraper\Models\Recipe;

trait ShowRequestsTrait
{
    /**
     * @param  string  $id
     * @return \NormanHuth\HelloFreshScraper\Models\Allergen
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     */
    public function allergen(string $id): Allergen
    {
        return new Allergen($this->request('allergens/' . $id));
    }

    /**
     * @param  string  $id
     * @return \NormanHuth\HelloFreshScraper\Models\Cuisine
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     */
    public function cuisine(string $id): Cuisine
    {
        return new Cuisine($this->request('cuisines/' . $id));
    }

    /**
     * @param  string  $id
     * @return \NormanHuth\HelloFreshScraper\Models\Ingredient
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     */
    public function ingredient(string $id): Ingredient
    {
        return new Ingredient($this->request('ingredients/' . $id));
    }

    /**
     * @param  string  $id
     * @return \NormanHuth\HelloFreshScraper\Models\Recipe
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     */
    public function recipe(string $id): Recipe
    {
        return new Recipe($this->request('recipes/' . $id));
    }
}
