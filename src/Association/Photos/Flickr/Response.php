<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Flickr;

use Psr\Http\Message\ResponseInterface;

class Response
{
    /**
     * The contents of the Guzzle response.
     *
     * @var object
     */
    protected $contents;

    /**
     * Create a new Response instance.
     */
    public function __construct(ResponseInterface $guzzleResponse)
    {
        $this->contents = unserialize($guzzleResponse->getBody()->getContents());
    }

    /**
     * Get magically a regular value from the contents of the Flickr API call.
     *
     * @param  string $variable
     */
    public function __get($variable)
    {
        return $this->contents[$variable];
    }

    /**
     * Get the status of the Flickr API call.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->contents['stat'];
    }

    /**
     * Get a '_content' value from the contents of the Flickr API call.
     *
     * @param  string $method
     * @return string
     */
    public function getContent($method)
    {
        return $this->contents[$method]['_content'];
    }
}
