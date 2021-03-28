<?php

declare(strict_types=1);

namespace Francken\Association\Soundboards\Http;

use Francken\Association\Soundboards\Soundboard;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class SoundboardsController
{
    public function index() : RedirectResponse
    {
        $soundboard = Soundboard::firstOrFail();
        return redirect()->action([self::class, 'show'], ['soundboard' => $soundboard]);
    }

    public function show(Soundboard $soundboard) : View
    {
        $soundboard->load(['sounds.member', 'sounds.audioMedia', 'sounds.imageMedia']);

        return view('association.soundboards.show', [
            'soundboard' => $soundboard,
            'sound' => null,
            'breadcrumbs' => [
                ['url' => '/association/', 'text' => 'Association'],
                ['url' => action([static::class, 'index']), 'text' => 'Soundboards'],
                ['url' => action([static::class, 'show'], ['soundboard' => $soundboard]), 'text' => $soundboard->name],
            ],
        ]);
    }
}
