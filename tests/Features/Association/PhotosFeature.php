<?php

declare(strict_types=1);

namespace Francken\Features\Association;

use Francken\Association\Photos\Album;
use Francken\Association\Photos\AlbumsRepository;
use Francken\Association\Photos\Http\Controllers\PhotosController;
use Francken\Association\Photos\NextcloudAlbumsRepository;
use Francken\Association\Photos\Photo;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PhotosFeature extends TestCase
{
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    /** @test */
    public function it_lets_the_user_see_photo_albums() : void
    {
        $this->app->instance(AlbumsRepository::class, $this->app->make(NextcloudAlbumsRepository::class));

        $album = factory(Album::class)->create([
            'title' => 'BBQ'
        ]);
        $photo = factory(Photo::class)->create([
            'album_id' => $album->id,
            'path' => 'albums/2023-09-07-bbq/photo_1.png'
        ]);

        $this->visit(action([PhotosController::class, 'index']))
            ->see('BBQ')
            ->click('BBQ')
            ->seePageIs(action([PhotosController::class, 'show'], ['album' => $album]))
            ->see($album->description)
            ->see($photo->title);
    }
}
