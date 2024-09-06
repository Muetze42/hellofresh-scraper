<?php

namespace NormanHuth\HelloFreshScraper\Http\Concerns;

use Illuminate\Support\Str;
use NormanHuth\HelloFreshScraper\Http\Paginator;
use NormanHuth\HelloFreshScraper\Models\Recipe;

trait IndexRequestsTrait
{
    /**
     * The namespace for the models.
     */
    protected string $modelNamespace = 'NormanHuth\HelloFreshScraper\Models\\';

    /**
     * @param  string  $uri
     * @param  int  $skip
     * @return object
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     */
    protected function indexRequest(string $uri, int $skip = 0): object
    {
        $response = $this->request($uri, [
            'skip' => $skip,
        ]);

        $class = $this->modelNamespace . ucfirst(Str::singular($uri));

        return (object) [
            'paginator' => new Paginator($response),
            'items' => collect(array_map(
                fn (array $item) => new $class($item),
                $response['items']
            )),
        ];
    }

    /**
     * @phpstan-return object
     *
     * @return object{
     *     paginator: \NormanHuth\HelloFreshScraper\Http\Paginator,
     *     items: \Illuminate\Support\Collection<array-key, \NormanHuth\HelloFreshScraper\Models\Allergen>
     * }
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     */
    public function allergens(int $skip = 0): object
    {
        return $this->indexRequest('allergens', $skip);
    }

    /**
     * @phpstan-return object
     *
     * @return object{
     *     paginator: \NormanHuth\HelloFreshScraper\Http\Paginator,
     *     items: \Illuminate\Support\Collection<array-key, \NormanHuth\HelloFreshScraper\Models\Cuisine>
     * }
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     */
    public function cuisines(int $skip = 0): object
    {
        return $this->indexRequest('cuisines', $skip);
    }

    /**
     * @phpstan-return object
     *
     * @return object{
     *     paginator: \NormanHuth\HelloFreshScraper\Http\Paginator,
     *     items: \Illuminate\Support\Collection<array-key, \NormanHuth\HelloFreshScraper\Models\Ingredient>
     * }
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     */
    public function ingredients(int $skip = 0): object
    {
        return $this->indexRequest('ingredients', $skip);
    }

    /**
     * @phpstan-return object
     *
     * @return object{
     *     paginator: \NormanHuth\HelloFreshScraper\Http\Paginator,
     *     items: \Illuminate\Support\Collection<array-key, \NormanHuth\HelloFreshScraper\Models\Recipe>
     * }
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     */
    public function recipes(int $skip = 0): object
    {
        return $this->indexRequest('recipes', $skip);
    }

    /**
     * @phpstan-return object
     *
     * @param  string  $id
     * @param  int  $take
     * @param  int  $skip
     * @return object{
     *      paginator: \NormanHuth\HelloFreshScraper\Http\Paginator,
     *      items: \Illuminate\Support\Collection<array-key, \NormanHuth\HelloFreshScraper\Models\Recipe>
     *  }
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     */
    public function recipeRecommendations(string $id, int $take = 10, int $skip = 0): object
    {
        $response = $this->request('recipes/' . $id . '/recommendations', [
            'skip' => $skip,
            'take' => $take,
        ]);

        return (object) [
            'paginator' => new Paginator($response),
            'items' => collect(array_map(
                fn (array $item) => new Recipe($item),
                $response
            )),
        ];
    }
}
