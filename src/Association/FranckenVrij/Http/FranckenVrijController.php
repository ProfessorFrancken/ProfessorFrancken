<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij\Http;

use Francken\Association\FranckenVrij\Edition;
use Francken\Shared\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class FranckenVrijController extends Controller
{
    public function index(Request $request) : View
    {
        $volumes = Edition::volumes(
            $request->user() ? null : 5
        );

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
