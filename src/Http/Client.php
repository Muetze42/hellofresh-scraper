<?php

namespace NormanHuth\HellofreshScraper\Http;

use DOMDocument;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException;
use NormanHuth\HellofreshScraper\Http\Responses\AllergensIndexResponse;
use NormanHuth\HellofreshScraper\Http\Responses\CuisinesIndexResponse;
use NormanHuth\HellofreshScraper\Http\Responses\IngredientsIndexResponse;
use NormanHuth\HellofreshScraper\Http\Responses\RecipesIndexResponse;
use NormanHuth\HellofreshScraper\Models\HelloFreshAllergen;
use NormanHuth\HellofreshScraper\Models\HelloFreshCuisine;
use NormanHuth\HellofreshScraper\Models\HelloFreshIngredient;
use NormanHuth\HellofreshScraper\Models\HelloFreshRecipe;

class Client
{
    /**
     * The HelloFresh base url.
     */
    protected string $baseUrl = 'https://gw.hellofresh.com';

    /**
     * The HelloFresh API path.
     */
    protected string $apiPath = '/gw/api/';

    /**
     * The ISO 3166-1 country code.
     */
    protected string $country;

    /**
     * The ISO 639-1 language code.
     */
    protected string $locale;

    /**
     * The limit of items for each index request.
     */
    protected int $take;

    protected bool $throwException = true;

    protected int $requestTry = 0;

    /**
     * Create a new HelleFresh API client instance.
     */
    public function __construct(string $isoCountryCode, string $isoLocale, int $take = 10, string $baseUrl = null)
    {
        $this->country = $isoCountryCode;
        $this->locale = $isoLocale;
        $this->take = $take;

        if (function_exists('set_time_limit')) {
            set_time_limit(0);
        }

        if ($baseUrl) {
            $this->baseUrl = $baseUrl;
        }
    }

    /**
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    protected function indexRequest(string $url, int $skip = 0, int $take = null): array
    {
        if (!$take) {
            $take = $this->take;
        }

        return $this->request($url, [
            'take' => $take,
            'skip' => $skip,
        ]);
    }

    /**
     * Issue a GET request to the HelloFresh API.
     *
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    protected function request(string $url, array $query = []): ?array
    {
        $query['country'] = $this->country;
        $query['locale'] = $this->locale . '-' . $this->country;

        $this->requestTry++;

        $response = Http::withToken($this->token())
            ->get($this->baseUrl . $this->apiPath . $url, $query);

        if ($response->failed()) {
            if ($response->status() == 404) {
                return null;
            }
            if ($response->status() == 401 && $this->requestTry < 3) {
                $this->refreshToken();
                sleep(1);

                return $this->request($url, $query);
            }

            switch ($this->requestTry) {
                case 1:
                    sleep(5);

                    return $this->request($url, $query);
                case 2:
                    sleep(10);

                    return $this->request($url, $query);
                default:
                    throw new HellofreshScraperException($this->requestTry . ' request failed.');
            }
        }

        return $response->json();
    }

    /**
     * Get HelloFresh Bearer Token.
     *
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    public function token(): string
    {
        $token = Cache::get('HelloFreshToken');

        if (!$token) {
            return $this->refreshToken();
        }

        return $token;
    }

    /**
     * Remove HelloFresh Bearer Token the cache.
     */
    public function forgetToken(): void
    {
        Cache::forget('HelloFreshToken');
    }

    /**
     * Refreshing HelloFresh Bearer Token.
     *
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    protected function refreshToken(): string
    {
        $token = $this->extractToken();
        Cache::forever('HelloFreshToken', $token);

        return $token;
    }

    /**
     * Extract HelloFresh Bearer Token from the HelloFresh website source code.
     *
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    protected function extractToken(): string
    {
        return $this->getSsrPayload(
            $this->baseUrl,
            'serverAuth.access_token'
        );
    }

    /**
     * Return an array of recipe IDs for the determined week.
     *
     *
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     * @return null|array{
     *      ids: array,
     *      year: int,
     *      weak: int,
     *      current: \Illuminate\Support\Carbon,
     * }
     */
    public function menu(int $addWeeks = 0): ?array
    {
        $current = now()->startOfWeek()->addWeeks($addWeeks);
        $year = $current->format('Y');
        $week = $current->format('W');
        $url = sprintf(
            '%s/menus/%d-W%d',
            $this->baseUrl,
            $year,
            $week
        );

        if ($payload = $this->getSsrPayload($url, 'courses')) {
            return [
                'ids' => Arr::pluck($payload, 'recipe.id'),
                'year' => $year,
                'weak' => $week,
                'current' => $current,
            ];
        }

        return null;
    }

    /**
     * Extract SSR Payload from specific URL.
     *
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    protected function getSsrPayload(string $url, string $key): mixed
    {
        $response = Http::get($url);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($response->body());
        $data = $dom->getElementById('__NEXT_DATA__');

        if (!$data) {
            throw new HellofreshScraperException('Element __NEXT_DATA__ not found.');
        }

        $data = $data->nodeValue;

        if (!Str::isJson($data)) {
            throw new HellofreshScraperException('__NEXT_DATA__ is not valid JSON.');
        }

        $data = json_decode($data, true);

        $data = data_get($data, 'props.pageProps.ssrPayload.' . $key);

        if (!$data) {
            if (!$this->throwException) {
                return null;
            }

            throw new HellofreshScraperException('Could not determine __NEXT_DATA__ key.');
        }

        return $data;
    }

    public function withoutException(): static
    {
        $this->throwException = false;

        return $this;
    }

    /**
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    public function allergens(int $skip = 0): AllergensIndexResponse
    {
        return new AllergensIndexResponse($this->indexRequest('allergens', $skip));
    }

    /**
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    public function cuisines(int $skip = 0): CuisinesIndexResponse
    {
        return new CuisinesIndexResponse($this->indexRequest('allergens', $skip));
    }

    /**
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    public function ingredients(int $skip = 0): IngredientsIndexResponse
    {
        return new IngredientsIndexResponse($this->indexRequest('ingredients', $skip));
    }

    /**
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    public function recipes(int $skip = 0): RecipesIndexResponse
    {
        return new RecipesIndexResponse($this->indexRequest('recipes', $skip));
    }

    /**
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    public function allergen(string $id): ?HelloFreshAllergen
    {
        $response = $this->request('allergens/' . $id);

        return $response ? new HelloFreshAllergen($response) : null;
    }

    /**
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    public function cuisine(string $id): ?HelloFreshCuisine
    {
        $response = $this->request('allergens/' . $id);

        return $response ? new HelloFreshCuisine($response) : null;
    }

    /**
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    public function ingredient(string $id): ?HelloFreshIngredient
    {
        $response = $this->request('ingredients' . $id);

        return $response ? new HelloFreshIngredient($response) : null;
    }

    /**
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    public function recipe(string $id): ?HelloFreshRecipe
    {
        $response = $this->request('recipes/' . $id);

        return $response ? new HelloFreshRecipe($response) : null;
    }

    /**
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    public function recipeRecommendations(string $id, int $take = 10, int $skip = 0): RecipesIndexResponse
    {
        return new RecipesIndexResponse($this->indexRequest(
            url: 'recipes/' . $id . '/recommendations',
            skip: $skip,
            take: $take
        ));
    }
}
