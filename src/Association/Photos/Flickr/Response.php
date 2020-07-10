<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Flickr;

use Psr\Http\Message\ResponseInterface;

/**
 * @property array $photosets
 * @property array $photoset
 */
class Response
{
    /**
     * The contents of the Guzzle response.
     */
    protected array $contents;

    /**
     * Create a new Response instance.
     */
    public function __construct(ResponseInterface $guzzleResponse)
    {
        $this->contents = unserialize($guzzleResponse->getBody()->getContents());
    }

    /**
     * Get magically a regular value from the contents of the Flickr API call.
     */
    public function __get(string $variable) : array
    {
        dump($variable);
        return $this->contents[$variable];
    }

    /**
     * Get the status of the Flickr API call.
     */
    public function getStatus() : string
    {
        return $this->contents['stat'];
    }

    /**
     * Get a '_content' value from the contents of the Flickr API call.
     */
    public function getContent(string $method) : string
    {
        return $this->contents[$method]['_content'];
    }
}
