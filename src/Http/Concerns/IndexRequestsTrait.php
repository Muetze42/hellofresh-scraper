<?php

namespace NormanHuth\HellofreshScraper\Http\Concerns;

use Illuminate\Support\Str;
use NormanHuth\HellofreshScraper\Http\Paginator;
use NormanHuth\HellofreshScraper\Models\Recipe;

trait IndexRequestsTrait
{
    /**
     * The namespace for the models.
     */
    protected string $modelNamespace = 'NormanHuth\HellofreshScraper\Models\\';

    /**
     * @phpstan-return  array<string, mixed>
     *
     * @param  string  $uri
     * @param  int  $skip
     * @return array<string, mixed>
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HellofreshScraper\Exceptions\ClientException
     */
    protected function indexRequest(string $uri, int $skip = 0): array
    {
        $response = $this->request($uri, [
            'skip' => $skip,
        ]);

        $class = $this->modelNamespace . ucfirst(Str::singular($uri));

        return [
            'paginator' => new Paginator($response),
            'items' => collect(array_map(
                fn (array $item) => new $class($item),
                $response
            )),
        ];
    }

    /**
     * @phpstan-return  array<string, mixed>
     *
     * @return array{
     *     paginator: \NormanHuth\HellofreshScraper\Http\Paginator,
     *     items: \Illuminate\Support\Collection<array-key, \NormanHuth\HellofreshScraper\Models\Allergen>
     * }
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HellofreshScraper\Exceptions\ClientException
     */
    public function allergens(int $skip = 0): array
    {
        return $this->indexRequest('allergens', $skip);
    }

    /**
     * @phpstan-return  array<string, mixed>
     *
     * @return array{
     *     paginator: \NormanHuth\HellofreshScraper\Http\Paginator,
     *     items: \Illuminate\Support\Collection<array-key, \NormanHuth\HellofreshScraper\Models\Cuisine>
     * }
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HellofreshScraper\Exceptions\ClientException
     */
    public function cuisines(int $skip = 0): array
    {
        return $this->indexRequest('cuisines', $skip);
    }

    /**
     * @phpstan-return  array<string, mixed>
     *
     * @return array{
     *     paginator: \NormanHuth\HellofreshScraper\Http\Paginator,
     *     items: \Illuminate\Support\Collection<array-key, \NormanHuth\HellofreshScraper\Models\Ingredient>
     * }
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HellofreshScraper\Exceptions\ClientException
     */
    public function ingredients(int $skip = 0): array
    {
        return $this->indexRequest('ingredients', $skip);
    }

    /**
     * @phpstan-return  array<string, mixed>
     *
     * @return array{
     *     paginator: \NormanHuth\HellofreshScraper\Http\Paginator,
     *     items: \Illuminate\Support\Collection<array-key, \NormanHuth\HellofreshScraper\Models\Recipe>
     * }
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HellofreshScraper\Exceptions\ClientException
     */
    public function recipes(int $skip = 0): array
    {
        return $this->indexRequest('recipes', $skip);
    }

    /**
     * @param  string  $id
     * @param  int  $take
     * @param  int  $skip
     * @return array{
     *      paginator: \NormanHuth\HellofreshScraper\Http\Paginator,
     *      items: \Illuminate\Support\Collection<array-key, \NormanHuth\HellofreshScraper\Models\Recipe>
     *  }
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HellofreshScraper\Exceptions\ClientException
     */
    public function recipeRecommendations(string $id, int $take = 10, int $skip = 0): array
    {
        $response = $this->request('recipes/' . $id . '/recommendations', [
            'skip' => $skip,
            'take' => $take,
        ]);

        return [
            'paginator' => new Paginator($response),
            'items' => collect(array_map(
                fn (array $item) => new Recipe($item),
                $response
            )),
        ];
    }
}
