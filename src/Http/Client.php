<?php

namespace NormanHuth\HellofreshScraper\Http;

use DOMDocument;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Sleep;
use Illuminate\Support\Str;
use NormanHuth\HellofreshScraper\Exceptions\ClientException;
use NormanHuth\HellofreshScraper\Http\Concerns\AuthorizationTrait;
use NormanHuth\HellofreshScraper\Http\Concerns\IndexRequestsTrait;
use NormanHuth\HellofreshScraper\Http\Concerns\ShowRequestsTrait;

class Client
{
    use AuthorizationTrait;
    use IndexRequestsTrait;
    use ShowRequestsTrait;

    /**
     * The HelloFresh base url.
     */
    protected string $baseUrl = 'https://hellofresh.de';

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

    /**
     * Indicates if the client should throw an exception if an error occurs.
     */
    protected bool $throwException = true;

    /**
     * The number of attempts of client requests.
     */
    protected int $requestAttempts = 0;

    /**
     * Create a new client instance.
     */
    public function __construct(string $country = 'DE', string $locale = 'de', int $take = 50)
    {
        $this->country = $country;
        $this->locale = $locale;
        $this->take = $take;
    }

    /**
     * Determine that the client should throw an exception if an error occurs.
     *
     * @return $this
     */
    public function throwException(bool $throw): static
    {
        $this->throwException = $throw;

        return $this;
    }

    /**
     * @param  array<int|string, mixed>  $query
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \NormanHuth\HellofreshScraper\Exceptions\ClientException
     */
    protected function request(string $uri, array $query = []): array
    {
        $this->requestAttempts++;

        $query = array_merge([
            'country' => $this->country,
            'locale' => $this->locale . '-' . $this->country,
            'take' => $this->take,
        ], $query);

        $response = Http::withToken($this->token())
            ->get($this->baseUrl . $this->apiPath . $uri, $query);

        if ($response->unauthorized() && $this->requestAttempts < 3) {
            $this->refreshToken();
            Sleep::for(0.5)->seconds();

            return $this->request($uri, $query);
        }

        $response->throw();

        $data = $response->json();

        if (! is_array($data) || (empty($data) && $this->throwException)) {
            throw new ClientException('Invalid body response.');
        }

        return $data;
    }

    /**
     * Extract SSR Payload from HelloFresh.
     *
     * @return array|mixed|null
     *
     * @throws \NormanHuth\HellofreshScraper\Exceptions\ClientException
     */
    protected function getSsrPayload(string $key): mixed
    {
        $response = Http::get($this->baseUrl);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($response->body());
        $data = $dom->getElementById('__NEXT_DATA__');

        if (! $data) {
            throw new ClientException('Could not found data HTML element.');
        }

        $data = $data->nodeValue;

        if (! is_string($data) || ! Str::isJson($data)) {
            throw new ClientException('The HTML element do not contains a valid JSON string.');
        }

        $data = data_get(json_decode($data, true), 'props.pageProps.ssrPayload.' . $key);

        if (! $data) {
            if (! $this->throwException) {
                return null;
            }

            throw new ClientException('Empty result.');
        }

        return $data;
    }
}
