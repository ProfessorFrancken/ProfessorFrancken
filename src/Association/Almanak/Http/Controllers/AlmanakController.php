<?php

declare(strict_types=1);

namespace Francken\Association\Almanak\Http\Controllers;

use Illuminate\View\View;

final class AlmanakController
{
    public function index() : View
    {
        $pages = collect(range(0, 143))->map(fn (int $idx) => "/images/association/almanak/almanak-page-{$idx}.png");
        $download  = "/images/association/almanak/almanak.pdf";

        return view('association.almanak', [
            'pages' => $pages,
            'download' => $download,
        ]);
    }
}
