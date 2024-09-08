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
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     *
     * @noinspection PhpMissingReturnTypeInspection
     */
    protected function indexRequest(string $uri, int $skip = 0)
    {
        $response = $this->request($uri, [
            'skip' => $skip,
        ]);

        $class = $this->modelNamespace . ucfirst(Str::singular($uri));

        return [
            'paginator' => new Paginator($response),
            'items' => (array_map(
                fn (array $item) => new $class($item),
                $response['items']
            )),
        ];
    }

    /**
     * @return array{
     *     paginator: \NormanHuth\HelloFreshScraper\Http\Paginator,
     *     items: array<array-key, \NormanHuth\HelloFreshScraper\Models\Allergen>
     * }
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     */
    public function allergens(int $skip = 0): array
    {
        return $this->indexRequest('allergens', $skip);
    }

    /**
     * @return array{
     *     paginator: \NormanHuth\HelloFreshScraper\Http\Paginator,
     *     items: array<array-key, \NormanHuth\HelloFreshScraper\Models\Cuisine>
     * }
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     */
    public function cuisines(int $skip = 0): array
    {
        return $this->indexRequest('cuisines', $skip);
    }

    /**
     * @return array{
     *     paginator: \NormanHuth\HelloFreshScraper\Http\Paginator,
     *     items: array<array-key, \NormanHuth\HelloFreshScraper\Models\Ingredient>
     * }
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     */
    public function ingredients(int $skip = 0): array
    {
        return $this->indexRequest('ingredients', $skip);
    }

    /**
     * @return array{
     *     paginator: \NormanHuth\HelloFreshScraper\Http\Paginator,
     *     items: list<\NormanHuth\HelloFreshScraper\Models\Recipe>
     * }
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     */
    public function recipes(int $skip = 0): array
    {
        return $this->indexRequest('recipes', $skip);
    }

    /**
     * @return array{
     *      paginator: \NormanHuth\HelloFreshScraper\Http\Paginator,
     *      items: array<array-key, \NormanHuth\HelloFreshScraper\Models\Recipe>
     *  }
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HelloFreshScraper\Exceptions\ClientException
     */
    public function recipeRecommendations(string $id, int $take = 10, int $skip = 0): array
    {
        $response = $this->request('recipes/' . $id . '/recommendations', [
            'skip' => $skip,
            'take' => $take,
        ]);

        return [
            'paginator' => new Paginator($response),
            'items' => (array_map(
                fn (array $item) => new Recipe($item),
                $response
            )),
        ];
    }
}
