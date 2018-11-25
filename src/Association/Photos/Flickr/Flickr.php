<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Flickr;

class Flickr
{
    /**
     * Flickr API class instance.
     *
     * @var Api
     */
    public $api;

    /**
     * Create a new Flickr instance.
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * Make a Flickr API request.
     *
     * @param  string                   $method
     * @param  array|null               $parameters
     * @return Response
     */
    public function request($method, $parameters = null)
    {
        return $this->api->request($method, $parameters);
    }

    /**
     * Flickr echo request, for testing purposes.
     *
     * @param  string                   $string
     * @return Response
     */
    public function echoThis($string)
    {
        return $this->request('flickr.test.echo', ['this' => $string]);
    }

    /**
     * Get a list of photosets.
     *
     * @param  array|null               $parameters
     * @return Response
     */
    public function listSets($parameters = null)
    {
        return $this->request('flickr.photosets.getList', $parameters);
    }

    /**
     * Get all photos in a photoset.
     *
     * @param  string                   $setId
     * @param  string                   $userId
     * @param  array|null               $otherParameters
     * @return Response
     */
    public function photosForSet($setId, $userId, $otherParameters = null)
    {
        $parameters['photoset_id'] = $setId;
        $parameters['user_id'] = $userId;

        if (is_array($otherParameters)) {
            $parameters = array_merge($parameters, $otherParameters);
        }

        return $this->request('flickr.photosets.getPhotos', $parameters);
    }

    /**
     * Get all info on a photo.
     *
     * @param  string                   $photoId
     * @param  string|null              $secretId
     * @return Response
     */
    public function photoInfo($photoId, $secretId = null)
    {
        $parameters['photo_id'] = $photoId;

        if ( ! is_null($secretId)) {
            $parameters['secret'] = $secretId;
        }

        return $this->request('flickr.photos.getInfo', $parameters);
    }
}
