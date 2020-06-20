<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use DateTimeImmutable;
use Francken\Association\Photos\Flickr\Api;
use Francken\Association\Photos\Flickr\Flickr;
use Illuminate\Support\Collection;

final class FlickrRepository
{
    private $flickr;
    private $user_id;
    private $secret;

    public function __construct()
    {
        $this->secret = config('services.flickr.secret');
        $this->user_id = config('services.flickr.user_id');

        $api_key = config('services.flickr.api_key');
        $this->flickr = new Flickr(new Api($api_key));
    }


    public function albums() : Collection
    {
        try {
            $photoset = $this->flickr->listSets([
                'user_id' => $this->user_id,
                'secret' => $this->secret,
                'primary_photo_extras' => 'url_sq,url_t,url_s,url_m,url_o,date_upload,date_taken,last_update'
            ]);
            $photosets = $photoset->photosets['photoset'];


            return collect($photosets)->map(function ($album) {
                $primary_photos = $album['primary_photo_extras'];
                $width = (int) ($primary_photos['width_m'] ?? $primary_photos['width_o']);
                $height = (int) ($primary_photos['height_m'] ?? $primary_photos['height_o']);
                $original_url = $primary_photos['url_o'];
                $url = $primary_photos['url_m'] ?? $primary_photos['url_o'];

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
                        'original_url' => $original_url,
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
        } catch (\Exception $e) {
            return collect();
        }
    }

    public function findAlbum($album_id): Collection
    {
        try {
            $album = $this->flickr->photosForSet(
                $album_id, // set id
                $this->user_id, // user id
                [
                    'extras' => 'icon_server,machine_tags,o_dims,views,media,path_alias,url_sq,url_t,url_s,url_m,url_o,original_format,date_upload,last_update,date_taken,geo',
                    'privacy_filter' => '1'
                ]
            )->photoset;

            return collect([
                'id' => $album['id'],
                'title' => $album['title'],
                'photos' => collect($album['photo'])->map(function ($photo) {
                    return collect([
                        'id' => $photo['id'],
                        'title' => $photo['title'],
                        'is_primary' => $photo['isprimary'],
                        'views' => $photo['views'],
                        'url' => $photo['url_m'],
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
        } catch (\Exception $e) {
            return collect([
                'id' => $album['id'] ?? '',
                'title' => $album['title'] ?? '',
                'photos' => collect()
            ]);
        }
    }
}
