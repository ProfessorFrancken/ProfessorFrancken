<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Illuminate\Http\RedirectResponse;

final class PicturesController
{
    public function show(string $url) : RedirectResponse
    {
        return redirect('http://old.professorfrancken.nl/database/streep/afbeeldingen/' . $url);
    }
}
