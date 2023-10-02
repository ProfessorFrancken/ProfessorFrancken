<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Francken\Extern\SponsorOptions\FccFooter;
use Illuminate\Support\Collection;
use Webmozart\Assert\Assert;

final class SponsorsController
{
    public function index() : Collection
    {
        /** @var Collection<int, FccFooter> $footers */
        $footers = FccFooter::where('is_enabled', '=', true)->with(['partner', 'logoMedia'])->get();

        return collect([
            'sponsors' => $footers->map(function (FccFooter $footer) {
                Assert::notNull($footer->partner);

                return [
                    'name' => $footer->partner->name,
                    'image' => $this->image($footer->logo ?? '')
                ];
            })
        ]);
    }

    private function image(string $url) : string
    {
        return image($url, ['width' => 300, 'height' => 300]);
    }
}
