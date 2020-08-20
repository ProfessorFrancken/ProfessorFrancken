<?php

declare(strict_types=1);

namespace Francken\Features\Shared;

use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Francken\Shared\Media\Http\Controllers\MediaController;
use Plank\Mediable\Media;

class MediaFeature extends TestCase
{
    use LoggedInAsAdmin;

    /** @test */
    public function it_allows_us_to_set_settings() : void
    {
        $media = factory(Media::class)->create();
        $this->visit(action([MediaController::class, 'index'], ['directory' => 'images']))
            ->see('media')
            ->visit(action([MediaController::class, 'index'], ['directory' => 'images/media']))
            ->see($media->filename)
            ->visit(action([MediaController::class, 'show'], ['media' => $media]))
            ->see('Basename');
    }
}
