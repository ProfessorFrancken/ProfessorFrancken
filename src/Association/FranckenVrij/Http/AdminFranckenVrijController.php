<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij\Http;

use Illuminate\Http\RedirectResponse;
use Francken\Association\FranckenVrij\Edition;
use Francken\Association\FranckenVrij\EditionId;
use Francken\Association\FranckenVrij\FileUploader;
use Francken\Association\FranckenVrij\Http\Requests\FranckenVrijRequest;
use Francken\Association\FranckenVrij\Volume;
use Francken\Shared\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

final class AdminFranckenVrijController extends Controller
{
    use ValidatesRequests;

    /**
     * @var int
     */
    private const ONE_HUNDRED_MB = 100 * 1024 * 1024;

    private FileUploader $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index()
    {
        $volumes = Edition::volumes();

        // Predict the next volume and edition numbers
        $currentVolume = $volumes->reduce(
            function (Volume $max, Volume $volume): Volume {
                return $volume->volume() > $max->volume() ? $volume : $max;
            },
            new Volume(1, [])
        );

        $currentEdition = array_reduce(
            $currentVolume->editions(),
            function (int $max, Edition $edition): int {
                return $edition->edition() > $max ? $edition->edition() : $max;
            },
            0
        );

        $currentVolume = $currentVolume->volume();
        if ($currentEdition === 3) {
            $currentVolume++;
            $currentEdition = 0;
        }
        $currentEdition++;

        $title = 'Francken Vrij ' . $currentVolume . '.' . $currentEdition;

        return view('admin.francken-vrij.index', [
            'volumes' => $volumes,
            'title' => $title,
            'volume' => $currentVolume,
            'edition' => $currentEdition,
            'breadcrumbs' => [
                ['url' => '/association', 'text' => 'Association'],
                ['url' => '/association/francken-vrij', 'text' => 'Francken Vrij'],
            ]
        ]);
    }

    /**
     * Store a new Francken Vrij edition
     */
    public function store(FranckenVrijRequest $request): RedirectResponse
    {
        $request->validate(['pdf' => ['required']]);

        $edition = new Edition([
            'id' => EditionId::generate(),
            'title' => $request->title(),
            'volume' => $request->volume(),
            'edition' => $request->edition(),
        ]);

        $this->uploader->uploadPdf($request, $edition);
        $edition->save();

        return redirect()->action([self::class, 'index']);
    }

    public function edit(Edition $edition)
    {
        return view('admin.francken-vrij.edit', ['edition' => $edition]);
    }

    public function update(FranckenVrijRequest $request, Edition $edition): RedirectResponse
    {
        $edition->update([
            'title' => $request->title(),
            'volume' => $request->volume(),
            'edition' => $request->edition(),
        ]);

        if ($request->hasFile('pdf')) {
            $this->uploader->uploadPdf($request, $edition);
            $edition->save();
        }

        return redirect()->action([self::class, 'index']);
    }

    public function destroy(Edition $edition): RedirectResponse
    {
        $edition->delete();

        return redirect()->action([self::class, 'index']);
    }
}
