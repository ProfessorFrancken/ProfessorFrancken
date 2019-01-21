<?php

namespace Francken\Association\Photos;

use Illuminate\Session\Store;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use DateTimeImmutable;
use DateInterval;

/**
 * We don't want unauthenticated people to view old albums, therefore
 * this repository will filter albums if a user isn't signed in
 */
final class AlbumsRepository
{
    private const SESSION_KEY = 'authenticated-for-viewing-albums';
    /**
     * @var Store
     */
    private $sessions;

    public function __construct(
        Store $sessions
    ) {
        $this->sessions = $sessions;
    }

    public function albums(): Paginator
    {
        $query = Album::where('is_public', true)
            ->with('coverPhoto')
            ->orderBy('activity_date', 'desc');

        $query = $this->filterPrivateAlbums($query);

        $albums = $query->simplePaginate(16);

        return $albums;
    }

    public function bySlug(string $album_slug): Album
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
        $this->sessions->put(self::SESSION_KEY, true);
        $authenticated = $this->sessions->get(self::SESSION_KEY, false);
        $authenticated = false;

        if (! $authenticated) {
            $one_year_ago = (new DateTimeImmutable)->sub(new DateInterval('P1Y'));

            $query = $query->whereDate('activity_date', '>=', $one_year_ago);
        }

        return $query;
    }
}
