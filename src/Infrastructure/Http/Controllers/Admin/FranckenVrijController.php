<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers\Admin;

use Francken\Application\FranckenVrij\Edition;
use Francken\Application\FranckenVrij\FranckenVrijRepository;
use Francken\Application\FranckenVrij\Volume;
use Francken\Domain\FranckenVrij\EditionId;
use Francken\Domain\Url;
use Francken\Infrastructure\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

final class FranckenVrijController extends Controller
{
    use ValidatesRequests;

    private $franckenVrij;
    private $storage;

    public function __construct(FranckenVrijRepository $franckenVrij, Factory $storage)
    {
        $this->franckenVrij = $franckenVrij;
        $this->storage = $storage;
    }

    public function index()
    {
        $volumes = $this->franckenVrij->volumes();

        // Predict the next volume and edition numbers
        $currentVolume = array_reduce(
            $volumes,
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
            'title' => 'required',
            'volume' => 'required|min:1',
            'edition' => 'required|min:1|max:3',
            'pdf' => 'required|file',
            'cover' => 'file'
        ]);

        $volume = (int)$request->get('volume');
        $edition= (int)$request->get('edition');

        list($coverPath, $pdfPath) = $this->uploadPdf(
            $request,
            $volume . '-' . $edition . '.pdf'
        );

        $edition = Edition::publish(
            EditionId::generate(),
            $request->get('title'),
            $volume,
            $edition,
            $coverPath,
            $pdfPath
        );

        $this->franckenVrij->save($edition);

        return redirect('/admin/association/francken-vrij');
    }

    public function edit(string $id)
    {
        $edition = $this->franckenVrij->find(new EditionId($id));

        return view('admin.francken-vrij.edit', ['edition' => $edition]);
    }

    public function update(string $id, Request $request)
    {
        $edition = $this->franckenVrij->find(new EditionId($id));

        $this->validate($request, [
            'title' => 'required',
            'volume' => 'required|min:1',
            'edition' => 'required|min:1|max:3',
            'pdf' => 'file'
        ]);

        $volume = (int)$request->get('volume');
        $editionNumber = (int)$request->get('edition');

        list($cover, $pdf) = $request->hasFile('pdf')
            ? $this->uploadPdf($request, $volume . '-' . $editionNumber . '.pdf')
            : [$edition->cover(), $edition->pdf()];

        $this->franckenVrij->save(
            Edition::publish(
                new EditionId($edition->getId()),
                $request->get('title'),
                $volume,
                $editionNumber,
                $cover,
                $pdf
            )
        );

        return redirect('/admin/association/francken-vrij');
    }

    public function destroy(string $id)
    {
        $this->franckenVrij->remove(new EditionId($id));

        return redirect('/admin/association/francken-vrij');
    }

    private function uploadPdf(Request $request, $filename)
    {
        $pdf = $request->file('pdf');
        $pdfPath = $pdf->storeAs('francken-vrij', $filename, 'public');
        $coverPath = preg_replace('"\.pdf$"', '-cover.png', $pdfPath);

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')
                ->storeAs(
                    'francken-vrij',
                    preg_replace('"\.pdf$"', '-cover.png', $filename),
                    'public'
                );
        } else {
            $this->generateCoverImageFromPdf(
                public_path() . $this->storage->url($pdfPath),
                $coverPath
            );
        }

        return [
            new Url(asset($this->storage->url($coverPath))),
            new Url(asset($this->storage->url($pdfPath)))
        ];
    }

    private function generateCoverImageFromPdf(string $pdfPath, string $coverPath) : string
    {
        $imagick = new \Imagick();
        $imagick->setCompressionQuality(100);
        $imagick->setResolution(300, 300);
        $imagick->readImage($pdfPath . '[0]');
        $imagick->resizeImage(175, 245, \Imagick::FILTER_LANCZOS, 0.9);
        $imagick->transformImageColorspace(\Imagick::COLORSPACE_SRGB);
        $imagick->setFormat('png');

        $this->storage->disk('public')->put($coverPath, $imagick);

        return $coverPath;
    }
}
