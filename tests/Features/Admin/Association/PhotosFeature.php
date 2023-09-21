<?php

declare(strict_types=1);

namespace Francken\Features\Admin\Association;

use Francken\Association\Photos\Album;
use Francken\Association\Photos\Http\Controllers\PhotosController;
use Francken\Association\Photos\Photo;
use Francken\Auth\Account;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotosFeature extends TestCase
{
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    /**
     * @test
     * @dataProvider permissionProvider
     */
    public function it_allows_users_to_view_photo_based_on_permissions($account, $visibility, $isAllowed) : void
    {
        $photo = $this->setupPhoto($visibility);

        $album = $photo->album;

        switch ($account) {
            case 'guest': {
                \Illuminate\Support\Facades\Auth::logout();
                break;
            }
            case 'member': {
                $account = factory(Account::class)->create();
                Auth::loginUsingId($account->id);
                break;
            }
            case 'admin': {
                break;
            }
        }



        if ( ! $isAllowed) {
            $this->withoutExceptionHandling();
            $this->expectException(ModelNotFoundException::class);
        }

        $this->visit(
            action([PhotosController::class, 'showImage'], ['album' => $album, 'photo' => $photo])
        );

        if ($isAllowed) {
            $this->assertResponseOk();
        }
    }

    /** @test */
    public function it_does_not_allow_viewing_a_photo_in_a_different_album() : void
    {
        $album = factory(Album::class)->create();
        $photo = factory(Photo::class)->create([
            'path' => 'albums/2023-09-07-bbq/photo_1.png'
        ]);

        $this->withoutExceptionHandling();
        $this->expectException(ModelNotFoundException::class);
        $this->visit(
            action([PhotosController::class, 'showImage'], ['album' => $album, 'photo' => $photo])
        );
    }

    public function permissionProvider()
    {
        return [
            // Guests can only see public photos & albums
            ['guest', 'public', true],
            ['guest', 'members-only', false],
            ['guest', 'private', false],
            // Members can only see public or members-only photos & albums
            ['member', 'public', true],
            ['member', 'members-only', true],
            ['member', 'private', false],
            // Admins can see any photos & albums
            ['admin', 'public', true],
            ['admin', 'members-only', true],
            ['admin', 'private', true],
        ];
    }

    private function setupPhoto(string $visibility) : Photo
    {
        $storage = Storage::fake('nextcloud');
        $storage->makeDirectory('images/albums/2023-09-07-bbq');
        $storage->put('images/albums/2023-09-07-bbq/photo_1.png', 'hoi_1');

        $album = factory(Album::class)->create([
            'visibility' => $visibility,
        ]);

        return factory(Photo::class)->create([
            'album_id' => $album->id,
            'path' => 'albums/2023-09-07-bbq/photo_1.png',
            'visibility' => $visibility,
        ]);
    }
}
