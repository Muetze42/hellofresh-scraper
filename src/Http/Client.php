<?php

namespace NormanHuth\HellofreshScraper\Http;

use DOMDocument;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException;
use NormanHuth\HellofreshScraper\Http\Responses\RecipesIndexResponse;

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

    protected int $requestTry = 0;

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
     * Issue a GET request to the HelloFresh API.
     *
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    public function request(string $url, array $query = []): array
    {
        // Debug
        return json_decode(
            file_get_contents(storage_path('app/recipes.json')),
            true
        );

        $this->requestTry++;

        $response = Http::withToken($this->token())
            ->get($this->baseUrl . $this->apiPath . $url, $query);

        if ($response->failed()) {
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
                    sleep(30);

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
        $response = Http::get($this->baseUrl);
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

        $data = data_get($data, 'props.pageProps.ssrPayload.serverAuth.access_token');

        if (!$data) {
            throw new HellofreshScraperException('Could not determine HelloFresh token.');
        }

        return $data;
    }

    /**
     * @throws \NormanHuth\HellofreshScraper\Exceptions\HellofreshScraperException
     */
    public function recipes(): RecipesIndexResponse
    {
        return new RecipesIndexResponse($this->request(''));
    }
}
