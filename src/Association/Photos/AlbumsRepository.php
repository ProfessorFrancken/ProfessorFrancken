<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Illuminate\Contracts\Pagination\Paginator;

interface AlbumsRepository
{
    /** @return Paginator<FlickrAlbum> | Paginator<Album> */
    public function albums() : Paginator;

    public function bySlug(string $albumSlug) : FlickrAlbum | Album;
}
