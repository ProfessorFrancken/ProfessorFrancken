<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use DateTimeImmutable;
use Exception;
use Francken\Association\Photos\Flickr\Api;
use Francken\Association\Photos\Flickr\Flickr;
use Francken\Association\Photos\Flickr\Response;
use Illuminate\Support\Collection;
use Webmozart\Assert\Assert;

final class FlickrRepository
{
    private Flickr $flickr;
    private string $userId;
    private string $secret;

    public function __construct()
    {
        $this->secret = config('services.flickr.secret');
        $this->userId = config('services.flickr.user_id');

        $apiKey = config('services.flickr.api_key');
        $this->flickr = new Flickr(new Api($apiKey));
    }


    public function albums() : Collection
    {
        try {
            $photoset = $this->flickr->listSets([
                'user_id' => $this->userId,
                'secret' => $this->secret,
                'primary_photo_extras' => 'url_sq,url_t,url_s,url_m,url_o,date_upload,date_taken,last_update'
            ]);

            Assert::isInstanceOf($photoset, Response::class);
            $photosets = $photoset->photosets['photoset'];


            return collect($photosets)->map(function ($album) : Collection {
                $primaryPhotos = $album['primary_photo_extras'];
                $width = (int) ($primaryPhotos['width_m'] ?? $primaryPhotos['width_o']);
                $height = (int) ($primaryPhotos['height_m'] ?? $primaryPhotos['height_o']);
                $originalUrl = $primaryPhotos['url_o'];
                $url = $primaryPhotos['url_m'] ?? $primaryPhotos['url_o'];

                return collect([
                    'id' => $album['id'],
                    'title' => $album['title']['_content'],
                    'description' => $album['description']['_content'],
                    'date_created' => DateTimeImmutable::createFromFormat('U', $album['date_create']),
                    'date_update' => DateTimeImmutable::createFromFormat('U', $album['date_update']),
                    'visibility' => $album['visibility_can_see_set'],
                    'primary' => [
                        'id' => $album['primary'],
                        'url' => $url,
                        'original_url' => $originalUrl,
                        'width' => $width,
                        'height' => $height,
                        'date_upload' => DateTimeImmutable::createFromFormat('U', $album['primary_photo_extras']['dateupload']),
                        'last_update' => DateTimeImmutable::createFromFormat('U', $album['primary_photo_extras']['lastupdate']),
                        'date_taken' => new DateTimeImmutable($album['primary_photo_extras']['datetaken']),
                    ],
                    'views' => $album['count_views'],
                    'is_public' => $album['visibility_can_see_set'],
                    'photos' => $album['photos'],
                ]);
            });
        } catch (Exception $e) {
            return collect();
        }
    }

    public function findAlbum(string $albumId) : Collection
    {
        try {
            $response = $this->flickr->photosForSet(
                $albumId,
                $this->userId,
                [
                    'extras' => 'icon_server,machine_tags,o_dims,views,media,path_alias,url_sq,url_t,url_s,url_m,url_o,original_format,date_upload,last_update,date_taken,geo',
                    'privacy_filter' => '1'
                ]
            );
            Assert::isInstanceOf($response, Response::class);
            $album = $response->photoset;

            return collect([
                'id' => $album['id'],
                'title' => $album['title'],
                'photos' => collect($album['photo'])->map(function ($photo) : Collection {
                    return collect([
                        'id' => $photo['id'],
                        'title' => $photo['title'],
                        'is_primary' => $photo['isprimary'],
                        'views' => $photo['views'],
                        'url' => $photo['url_m'] ?? $photo['url_o'],
                        'original_url' => $photo['url_o'],
                        'width' => $photo['width_m'],
                        'height' => $photo['height_m'],
                        'is_public' => $photo['ispublic'],
                        'date_taken' => new DateTimeImmutable($photo['datetaken']),
                        'date_upload' => DateTimeImmutable::createFromFormat('U', $photo['dateupload']),
                        'last_update' => DateTimeImmutable::createFromFormat('U', $photo['lastupdate']),
                        'longitude' => $photo['longitude'],
                        'latitude' => $photo['latitude'],
                    ]);
                })
            ]);
        } catch (Exception $e) {
            return collect([
                'id' => $album['id'] ?? '',
                'title' => $album['title'] ?? '',
                'photos' => collect()
            ]);
        }
    }
}
