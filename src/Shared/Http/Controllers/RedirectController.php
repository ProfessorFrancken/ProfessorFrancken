<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

final class RedirectController
{
    public function wordpress(string $url)
    {
        return redirect('http://old.professorfrancken.nl/wordpress/' . $url);
    }

    public function scriptcie(string $url)
    {
        return redirect('http://old.professorfrancken.nl/scriptcie/' . $url);
    }
}
