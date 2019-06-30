<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

final class PicturesController
{
    public function show(string $url)
    {
        return redirect('http://old.professorfrancken.nl/database/streep/afbeeldingen/' . $url);
    }
}
