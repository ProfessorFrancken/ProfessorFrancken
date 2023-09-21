<?php

declare(strict_types=1);

namespace Francken\Features\Admin\Association;

use Francken\Association\Photos\Album;
use Francken\Association\Photos\Http\Controllers\AdminPhotoAlbumsController;
use Francken\Association\Photos\Http\Controllers\AdminPhotosController;
use Francken\Association\Photos\Photo;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;

class PhotoAlbumsFeature extends TestCase
{
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    /** @test */
    public function it_creates_albums_from_a_nextcloud_filesystem() : void
    {
        // Setup
        $storage = Storage::fake('nextcloud');
        $storage->makeDirectory('images/albums/test-123');
        $storage->makeDirectory('images/albums/2023-09-07-bbq');
        $storage->put('images/albums/2023-09-07-bbq/photo_1.png', 'hoi_1');
        $storage->put('images/albums/2023-09-07-bbq/photo_2.png', 'hoi_2');
        $storage->put('images/albums/2023-09-07-bbq/photo_3.png', 'hoi_3');


        // Create new BBQ album
        $this->createBbqAlbum();

        /**  Album $album */
        $album = Album::latest()->firstOrFail();
        $this->assertCount(3, $album->photos);

        // Edit album and first photo
        $this->editBbqAlbum($album);
        $album->refresh();
        $this->assertEquals('BBQ day', $album->title);
        $this->assertEquals('BBQ day', $album->description);

        /**  @var Photo $photo */
        $photo = $album->photos()->firstOrFail();
        $this->editPhoto($album, $photo);

        $photo->refresh();
        $this->assertEquals('Photo 1', $photo->name);
        $this->assertEquals('private', $photo->visibility);
        // Remove album
        $this->removeAlbum($album);
        $album->refresh();
        $this->assertNull(Album::find($album->id));
    }

    private function createBbqAlbum() : void
    {
        $this->visit(action([AdminPhotoAlbumsController::class, 'index']))
            ->see('Photo albums')
            ->click('Create album')
            //  TODO
            ->select('/albums/2023-09-07-bbq', 'path')
            ->type('BBQ', 'title')
            ->type('BBQ', 'description')
            ->type('2023-09-09', 'published_at')
            ->select('public', 'visibility')
            ->press('Add album');
    }

    private function editBbqAlbum(Album $album) : void
    {
        $this
            ->seePageIs(action([AdminPhotoAlbumsController::class, 'show'], ['album' => $album]))
            ->click('Edit album')
            ->seePageIs(action([AdminPhotoAlbumsController::class, 'edit'], ['album' => $album]))
            ->type('BBQ day', 'title')
            ->type('BBQ day', 'description')
            ->type('2023-09-10', 'published_at')
            ->select('private', 'visibility')
            ->press('Save');
    }

    private function editPhoto(Album $album, Photo $photo) : void
    {
        $this->click($photo->name)
            ->seePageIs(action([AdminPhotosController::class, 'edit'], ['album' => $album, 'photo' => $photo]))
            ->type('Photo 1', 'name')
            ->select('private', 'visibility')
            ->press('Update')
            ->seePageIs(action([AdminPhotoAlbumsController::class, 'show'], ['album' => $album]));
    }

    private function removeAlbum(Album $album) : void
    {
        $this
            ->seePageIs(action([AdminPhotoAlbumsController::class, 'show'], ['album' => $album]))
            ->press('here')
            ->seePageIs(action([AdminPhotoAlbumsController::class, 'index']));
    }
}
