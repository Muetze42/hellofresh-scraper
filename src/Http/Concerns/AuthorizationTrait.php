<?php

namespace NormanHuth\HellofreshScraper\Http\Concerns;

use Illuminate\Support\Facades\Cache;
use NormanHuth\HellofreshScraper\Exceptions\ClientException;

trait AuthorizationTrait
{
    /**
     * Get authorization token.
     *
     * @return string
     *
     * @throws \NormanHuth\HellofreshScraper\Exceptions\ClientException
     */
    public function token(): string
    {
        $token = $this->getToken();

        if (! $token || ! is_string($token)) {
            return $this->refreshToken();
        }

        return $token;
    }

    /**
     * Remove authorization token form the Cache.
     */
    public function forgetToken(): void
    {
        Cache::forget('HelloFreshToken');
    }

    /**
     * Get a new authorization token.
     *
     * @return string
     *
     * @throws \NormanHuth\HellofreshScraper\Exceptions\ClientException
     */
    public function refreshToken(): string
    {
        $token = $this->getSsrPayload('serverAuth.access_token');

        if (! is_string($token)) {
            throw new ClientException('Invalid or empty token.');
        }

        $this->storeToken($token);

        return $token;
    }

    /**
     * Store the current authorization token to the Cache.
     *
     * @param  string  $token
     * @return void
     */
    protected function storeToken(string $token): void
    {
        Cache::forever('HelloFreshToken', $token);
    }

    /**
     * Retrieving authorization token from the Cache
     *
     * @return mixed
     */
    protected function getToken(): mixed
    {
        return Cache::get('HelloFreshToken');
    }
}
