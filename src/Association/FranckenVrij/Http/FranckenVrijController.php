<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij\Http;

use Francken\Association\FranckenVrij\Edition;
use Francken\Shared\Http\Controllers\Controller;

final class FranckenVrijController extends Controller
{
    public function index()
    {
        $volumes = Edition::volumes();

        $latestEditions = $volumes->isNotEmpty()
            ? $volumes->first()->editions()
            : collect();

        return view('association.francken-vrij')
            ->with([
                'latestEditions' => $latestEditions,
                'volumes' => $volumes->skip(1),
                'breadcrumbs' => [
                    ['url' => '/association', 'text' => 'Association'],
                    ['text' => 'Francken Vrij'],
                ],
            ]);
    }
}
