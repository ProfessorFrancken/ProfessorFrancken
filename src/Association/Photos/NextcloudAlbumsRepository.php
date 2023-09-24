<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use DateInterval;
use DateTimeImmutable;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Webmozart\Assert\Assert;

/**
 * We don't want unauthenticated people to view old albums, therefore
 * this repository will filter albums if a user isn't signed in
 */
final class NextcloudAlbumsRepository implements AlbumsRepository
{
    private Gate $gate;

    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }

    /** @return Paginator<Album> */
    public function albums() : Paginator
    {
        $query = Album::query()
               ->whereHas('photos')
            ->with('coverPhoto')
               ->with('photos')
            ->orderBy('published_at', 'desc');

        $query = $this->filterPrivateAlbums($query);

        return $query->simplePaginate(16);
    }

    public function bySlug(string $albumSlug) : Album
    {
        $query = Album::where('slug', $albumSlug)
            ->with('photos');

        $query = $this->filterPrivateAlbums($query);

        /** @var Album $album */
        $album = $query->firstOrFail();

        Assert::isInstanceOf($album, Album::class);

        return $album;
    }


    /**
     * @param Builder<Album> $query
     * @return Builder<Album>
     **/
    private function filterPrivateAlbums(Builder $query) : Builder
    {
        // Check whether the user is either authenticated or authenticated by entering
        // the photos password
        $authenticated = $this->gate->allows('view-members-only-albums');

        if ( ! $authenticated) {
            $oneYearAgo = (new DateTimeImmutable())->sub(new DateInterval('P1Y'));

            $query = $query->whereDate('activity_date', '>=', $oneYearAgo);
        }

        return $query;
    }
}
