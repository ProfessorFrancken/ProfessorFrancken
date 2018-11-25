<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Illuminate\Database\Eloquent\Model;

final class Photo extends Model
{
    private const SIZES = [
        75 => "_s",
        150 => "_q",
        240 => "_m",
        320 => "_n",
        640 => "_z",
        800 => "_c",
        1024 => "_b",
        1600 => "_h",
        2048 => "_k",
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function src($quality = 1600) : string
    {
        $base_url = str_before($this->flickr_base_url, '.jpg');

        return sprintf(
            "%s%s.jpg",
            $base_url,
            self::SIZES[$quality]
        );
    }

    /**
     * Get a srcset so that browsers can choose a src based on device width
     */
    public function srcset(float $divider = 2.0) : string
    {
        $base_url = str_before($this->flickr_base_url, '.jpg');

        // Give a list of srces
        return collect(self::SIZES)
            ->map(function ($value, $key) use ($base_url) {
                return sprintf(
                    "%s%s.jpg %sw",
                    $base_url,
                    $value,
                    round($key * 1.5)
                );
            })
            ->implode(', ');
    }
}
