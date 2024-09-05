<?php

namespace NormanHuth\HellofreshScraper\Http;

use DOMDocument;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException;
use NormanHuth\HellofreshScraper\Resources\AllergenResource;
use NormanHuth\HellofreshScraper\Resources\Collections\AllergenCollection;
use NormanHuth\HellofreshScraper\Resources\Collections\CuisineCollection;
use NormanHuth\HellofreshScraper\Resources\Collections\IngredientCollection;
use NormanHuth\HellofreshScraper\Resources\Collections\RecipeCollection;
use NormanHuth\HellofreshScraper\Resources\CuisineResource;
use NormanHuth\HellofreshScraper\Resources\IngredientResource;
use NormanHuth\HellofreshScraper\Resources\RecipeResource;

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
    public function __construct(string $isoCountryCode, string $isoLocale, int $take = 10, ?string $baseUrl = null)
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
     * @return null|array{
     *     items: array<int, array<string, mixed>>,
     *     take: int,
     *     skip: int,
     *     count: int,
     *     total: int,
     * }
     *
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    protected function indexRequest(string $url, int $skip = 0, ?int $take = null): ?array
    {
        if (! $take) {
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
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>|null
     *
     * @throws \Illuminate\Http\Client\ConnectionException
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

        $data = $response->json();

        return is_array($data) ? $data : null;
    }

    /**
     * Get HelloFresh Bearer Token.
     *
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    public function token(): string
    {
        $token = Cache::get('HelloFreshToken');

        if (! $token || is_string($token)) {
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
     * @phpstan-return string
     */
    protected function extractToken(): string
    {
        return $this->getSsrPayload(
            $this->baseUrl,
            'serverAuth.access_token',
            ''
        );
    }

    /**
     * Return an array of recipe IDs for the determined week.
     *
     * @return null|array{
     *      ids: array,
     *      year: numeric-string,
     *      weak: numeric-string,
     *      current: \Illuminate\Support\Carbon,
     * }
     *
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
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
            if (is_array($payload)) {
                return [
                    'ids' => Arr::pluck($payload, 'recipe.id'),
                    'year' => $year,
                    'weak' => $week,
                    'current' => $current,
                ];
            }
        }

        return null;
    }

    /**
     * Extract SSR Payload from specific URL.
     *
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    protected function getSsrPayload(string $url, string $key): ?string
    {
        $response = Http::get($url);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($response->body());
        $data = $dom->getElementById('__NEXT_DATA__');

        if (! $data) {
            throw new HellofreshScraperException('Element __NEXT_DATA__ not found.');
        }

        $data = $data->nodeValue;

        if (! is_string($data) || ! Str::isJson($data)) {
            throw new HellofreshScraperException('__NEXT_DATA__ is not valid JSON.');
        }

        $data = json_decode($data, true);

        $data = data_get($data, 'props.pageProps.ssrPayload.' . $key);

        if (! $data) {
            if (! $this->throwException) {
                return null;
            }

            throw new HellofreshScraperException('Could not determine __NEXT_DATA__ key.');
        }

        return $data;
    }

    /**
     * @return $this
     */
    public function withoutException(): static
    {
        $this->throwException = false;

        return $this;
    }

    /**
     * @param int  $skip
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     * @return \NormanHuth\HellofreshScraper\Resources\Collections\AllergenCollection|null
     */
    public function allergens(int $skip = 0): ?AllergenCollection
    {
        $response = $this->indexRequest('allergens', $skip);

        if (is_array($response)) {
            return new AllergenCollection($response);
        }

        return null;
    }

    /**
     * @param int  $skip
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     * @return \NormanHuth\HellofreshScraper\Resources\Collections\CuisineCollection|null
     */
    public function cuisines(int $skip = 0): ?CuisineCollection
    {
        $response = $this->indexRequest('cuisines', $skip);

        if (is_array($response)) {
            return new CuisineCollection($response);
        }

        return null;
    }

    /**
     * @param int  $skip
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     * @return \NormanHuth\HellofreshScraper\Resources\Collections\IngredientCollection|null
     */
    public function ingredients(int $skip = 0): ?IngredientCollection
    {
        $response = $this->indexRequest('ingredients', $skip);

        if (is_array($response)) {
            return new IngredientCollection($response);
        }

        return null;
    }

    /**
     * @param int  $skip
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     * @return \NormanHuth\HellofreshScraper\Resources\Collections\RecipeCollection|null
     */
    public function recipes(int $skip = 0): ?RecipeCollection
    {
        $response = $this->indexRequest('recipes', $skip);

        if (is_array($response)) {
            return new RecipeCollection($response);
        }

        return null;
    }

    /**
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function allergen(string $id): ?AllergenResource
    {
        $response = $this->request('allergens/' . $id);

        return $response ? new AllergenResource($response) : null;
    }

    /**
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function cuisine(string $id): ?CuisineResource
    {
        $response = $this->request('cuisines/' . $id);

        return $response ? new CuisineResource($response) : null;
    }

    /**
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function ingredient(string $id): ?IngredientResource
    {
        $response = $this->request('ingredients/' . $id);

        return $response ? new IngredientResource($response) : null;
    }

    /**
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function recipe(string $id): ?RecipeResource
    {
        $response = $this->request('recipes/' . $id);

        return $response ? new RecipeResource($response) : null;
    }

    /**
     * @return array<int, \NormanHuth\HellofreshScraper\Resources\RecipeResource>
     *
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function recipeRecommendations(string $id, int $take = 10, int $skip = 0): array
    {
        return array_map(
            fn (array $allergen) => new RecipeResource($allergen),
            $this->indexRequest(
                url: 'recipes/' . $id . '/recommendations',
                skip: $skip,
                take: $take
            )
        );
    }
}
