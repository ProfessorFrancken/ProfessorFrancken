<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use Illuminate\Http\RedirectResponse;

final class RedirectController
{
    public function wordpress(string $url) : RedirectResponse
    {
        return redirect('http://old.professorfrancken.nl/wordpress/' . $url);
    }

    public function scriptcie(string $url) : RedirectResponse
    {
        return redirect('http://old.professorfrancken.nl/scriptcie/' . $url);
    }
}
