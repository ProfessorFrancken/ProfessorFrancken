<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use DateInterval;
use DateTimeImmutable;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Pagination\Paginator;

/**
 * We don't want unauthenticated people to view old albums, therefore
 * this repository will filter albums if a user isn't signed in
 */
final class AlbumsRepository
{
    private const SESSION_KEY = 'authenticated-for-viewing-albums';

    /**
     * @var Gate
     */
    private $gate;

    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }

    public function albums() : Paginator
    {
        $query = Album::where('is_public', true)
            ->with('coverPhoto')
            ->orderBy('activity_date', 'desc');

        $query = $this->filterPrivateAlbums($query);

        $albums = $query->simplePaginate(16);

        return $albums;
    }

    public function bySlug(string $album_slug) : Album
    {
        $query = Album::where('slug', $album_slug)
            ->where('is_public', true)
            ->with('photos');

        $query = $this->filterPrivateAlbums($query);

        $album = $query->firstOrFail();

        return $album;
    }

    private function filterPrivateAlbums($query)
    {
        // Check whether the user is either authenticated or authenticated by entering
        // the photos password
        $authenticated = $this->gate->allows('view-private-albums');

        if ( ! $authenticated) {
            $one_year_ago = (new DateTimeImmutable())->sub(new DateInterval('P1Y'));

            $query = $query->whereDate('activity_date', '>=', $one_year_ago);
        }

        return $query;
    }
}
