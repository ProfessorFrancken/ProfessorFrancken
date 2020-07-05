<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Flickr;

use GuzzleHttp\Client;

class Api
{
    /**
     * Flickr API response format.
     */
    public string $format;
    /**
     * Flickr API key.
     */
    protected string $key;

    /**
     * Guzzle Client instance.
     */
    protected Client $client;

    /**
     * Create a new Flickr Api instance.
     *
     * @param  string $apiKey
     * @param  string $format
     * @param  string $endpoint
     * @return void
     */
    public function __construct(string $apiKey, string $format = 'php_serial', string $endpoint = 'https://api.flickr.com/services/rest/')
    {
        $this->key = $apiKey;
        $this->format = $format;

        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $endpoint,
        ]);
    }

    /**
     * Make a Flickr API request.
     *
     * @param  string                   $call
     * @param  array|null               $parameters
     * @return Response|string
     */
    public function request(string $call, ?array $parameters = null)
    {
        $guzzleResponse = $this->client->get($this->api() . '&method=' . $call . $this->parameters($parameters));

        if ($guzzleResponse->getStatusCode() == 200) {
            return new Response($guzzleResponse);
        }
        return 'Failed request';
    }

    /**
     * Compile the standard API part of the REST request.
     */
    protected function api(): string
    {
        return '?api_key=' . $this->key . '&format=' . $this->format;
    }

    /**
     * Compile the parameters from an array into a string.
     *
     * @param  array  $array
     */
    protected function parameters(array $array): string
    {
        if ( ! is_array($array)) {
            return '';
        }
        $encoded = [];

        foreach ($array as $k => $v) {
            $encoded[] = urlencode($k) . '=' . urlencode($v);
        }

        return '&' . implode('&', $encoded);
    }
}
