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
use Illuminate\Http\UploadedFile;

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
            'useFrontPageAsCover' => true,
        ]);
    }

    /**
     * Store a new Francken Vrij edition
     */
    public function store(Request $request)
    {
        $title = $request->get('title');
        $volume = (int)$request->get('volume');
        $edition = (int)$request->get('edition');

        $this->validate($request, [
            'title' => 'required',
            'volume' => 'required|min:1',
            'edition' => 'required|min:1|max:3',
            'pdf' => 'required|file'
        ]);

        $edition = $this->createEdition(
            $title,
            $volume,
            $edition,
            $request->file('pdf')
        );

        $this->franckenVrij->save($edition);

        return redirect('/admin/francken-vrij');
    }

    private function createEdition(
        string $title,
        int $volume,
        int $edition,
        UploadedFile $pdf
    ) : Edition {
        $pdfPath = $pdf->storeAs('francken-vrij', $volume . '-' . $edition . '.pdf', 'public');
        $coverPath = preg_replace('"\.pdf$"', '-cover.png', $pdfPath);

        $this->generateCoverImageFromPdf(
            public_path() . $this->storage->url($pdfPath),
            $coverPath
        );

        return Edition::publish(
            EditionId::generate(),
            $title,
            $volume,
            $edition,
            new Url(asset($this->storage->url($coverPath))),
            new Url(asset($this->storage->url($pdfPath)))
        );
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
