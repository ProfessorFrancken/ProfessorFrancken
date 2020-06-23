<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij\Http;

use Francken\Association\FranckenVrij\FranckenVrijRepository;
use Francken\Association\FranckenVrij\Volume;
use Francken\Shared\Http\Controllers\Controller;

final class FranckenVrijController extends Controller
{
    private $franckenVrij;

    public function __construct(FranckenVrijRepository $franckenVrij)
    {
        $this->franckenVrij = $franckenVrij;
    }

    public function index()
    {
        $volumes = collect($this->franckenVrij->volumes());
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
