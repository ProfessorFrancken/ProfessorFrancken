<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use DateInterval;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

final class SynchronizeFlickrAlbums extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photos:synchronize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store all albums from Flickr';

    private FlickrRepository $flickrRepo;

    private ConnectionInterface $db;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ConnectionInterface $db)
    {
        // We will need to have a database connection
        // and flikr api

        parent::__construct();

        $this->flickrRepo = new FlickrRepository();
        $this->db = $db;
    }

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $albums = $this->flickrRepo->albums();
        $albumsInDb = $this->db->table('albums')->get();

        // Check which albums have already been synchronized
        foreach ($this->missingAlbums($albums, $albumsInDb->pluck('id')) as $album) {
            $this->info("Adding a missing album");
            $this->storeAlbum($album);
        }
    }

    private function missingAlbums(Collection $albums, Collection $albumsInDb) : Collection
    {
        return $albums->filter(function ($album) use ($albumsInDb) : bool {
            return ! $albumsInDb->contains($album['id']);
        });
    }

    private function storeAlbum($album) : void
    {
        $publicationDate = $album['date_created'];
        $activityDate = $album['primary']['date_taken']->sub(new DateInterval('PT6H'))->format('Y-m-d');

        $photoAlbum = $this->flickrRepo->findAlbum($album['id']);


        $photos = $photoAlbum['photos']->map(function ($photo) use ($album) : array {
            $parseTitle = function ($title) {
                return Str::startsWith($title, 'IMG_') ? '' : $title;
            };

            $width = (int)$photo['width'];
            $height = (int)$photo['height'];

            return [
                'id' => $photo['id'],
                'album_id' => $album['id'],
                'title' => $parseTitle($photo['title']),
                'is_public' => $photo['is_public'],
                'views' => $photo['views'],
                'flickr_base_url' => $photo['url'],
                'flickr_original_url' => $photo['original_url'],

                'is_tall' => $height > $width,
                'is_wide' => false,

                'created_at' => $photo['date_upload'],
                'updated_at' => $photo['last_update'],
                'taken_at' => $photo['date_taken'],
                'longitude' => $photo['longitude'],
                'latitude' => $photo['latitude'],
            ];
        });

        $title = Str::after($album['title'], $activityDate . " ");
        $slug = Str::slug($activityDate . '-' . $title);

        try {
            $this->db->table('albums')->insert([
                'id' => $album['id'],
                'published_at' => $album['date_created'],
                'activity_date' => $activityDate,

                'title' => $title,
                'description' => $album['description'],
                'slug' => $slug,

                'is_public' => $album['is_public'] === 1,
                'cover_photo' => $album['primary']['id'],

                'views' => $album['views'],
                'amount_of_photos' => $album['photos'],

                'created_at' => $album['date_created'],
                'updated_at' => $album['date_update'],
            ]);
        } catch (Exception $e) {
            $this->info("Something went wrong {$album['title']} - {$album['id']}");
            return;
        }

        foreach ($photos as $photo) {
            try {
                $this->db->table('photos')->insert($photo);
            } catch (Exception $e) {
                $this->info("Something went wrong {$album['title']} - {$album['id']} - {$photo['id']}");
            }
        }
        $this->info("Imported photos from: {$album['title']}");
    }
}
