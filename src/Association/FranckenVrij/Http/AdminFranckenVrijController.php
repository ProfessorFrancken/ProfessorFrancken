<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij\Http;

use Francken\Association\FranckenVrij\Edition;
use Francken\Association\FranckenVrij\EditionId;
use Francken\Association\FranckenVrij\FileUploader;
use Francken\Association\FranckenVrij\Volume;
use Francken\Shared\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

final class AdminFranckenVrijController extends Controller
{
    use ValidatesRequests;

    private const ONE_HUNDRED_MB = 100 * 1024 * 1024;

    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index()
    {
        $volumes = Edition::volumes();

        // Predict the next volume and edition numbers
        $currentVolume = $volumes->reduce(
            function (Volume $max, Volume $volume) {
                return $volume->volume() > $max->volume() ? $volume : $max;
            },
            new Volume(1, [])
        );

        $currentEdition = array_reduce(
            $currentVolume->editions(),
            function (int $max, Edition $edition) {
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'volume' => ['required', 'min:1'],
            'edition' => ['required', 'min:1', 'max:3'],
            'pdf' => ['required', 'file'],
            'cover' => ['nullable', 'image']
        ]);

        $volume = (int)$request->get('volume');
        $editionNumber = (int)$request->get('edition');
        $id = EditionId::generate();

        $edition = new Edition([
            'id' => $id,
            'title' => $request->get('title'),
            'volume' => $volume,
            'edition' => $editionNumber,
        ]);

        $this->uploader->uploadPdf($request, $edition);

        $edition->save();

        return redirect('/admin/association/francken-vrij');
    }

    public function edit(Edition $edition)
    {
        return view('admin.francken-vrij.edit', ['edition' => $edition]);
    }

    public function update(Edition $edition, Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'volume' => ['required', 'min:1'],
            'edition' => ['required', 'min:1', 'max:3'],
            'pdf' => ['nullable', 'file'],
            'cover' => ['nullable', 'image']
        ]);

        $volume = (int)$request->get('volume');
        $editionNumber = (int)$request->get('edition');

        if ($request->hasFile('pdf')) {
            $this->uploader->uploadPdf($request, $edition);
        }

        $edition->update([
            'title' => $request->input('title'),
            'volume' => $volume,
            'edition' => $editionNumber,
        ]);

        return redirect('/admin/association/francken-vrij');
    }

    public function destroy(Edition $edition)
    {
        $edition->delete();

        return redirect('/admin/association/francken-vrij');
    }
}
