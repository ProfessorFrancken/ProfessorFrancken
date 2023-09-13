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
final class AlbumsRepository
{
    private Gate $gate;

    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }

    public function albums() : Paginator
    {
        $query = FlickrAlbum::where('is_public', true)
            ->with('coverPhoto')
            ->orderBy('activity_date', 'desc');

        $query = $this->filterPrivateAlbums($query);

        return $query->simplePaginate(16);
    }

    public function bySlug(string $albumSlug) : FlickrAlbum
    {
        $query = FlickrAlbum::where('slug', $albumSlug)
            ->where('is_public', true)
            ->with('photos');

        $query = $this->filterPrivateAlbums($query);

        /** @var FlickrAlbum $album */
        $album = $query->firstOrFail();

        Assert::isInstanceOf($album, FlickrAlbum::class);

        return $album;
    }


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
