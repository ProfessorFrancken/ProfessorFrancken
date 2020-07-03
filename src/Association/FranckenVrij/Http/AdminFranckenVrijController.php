<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij\Http;

use Francken\Association\FranckenVrij\Edition;
use Francken\Association\FranckenVrij\EditionId;
use Francken\Association\FranckenVrij\Volume;
use Francken\Shared\Http\Controllers\Controller;
use Francken\Shared\Url;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Plank\Mediable\Media;
use Plank\Mediable\MediaUploader;

final class AdminFranckenVrijController extends Controller
{
    use ValidatesRequests;

    private const ONE_HUNDRED_MB = 100 * 1024 * 1024;

    private $uploader;

    public function __construct(MediaUploader $uploader)
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
            'title' => 'required',
            'volume' => 'required|min:1',
            'edition' => 'required|min:1|max:3',
            'pdf' => 'required|file',
            'cover' => 'file'
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

        list($coverPath, $pdfPath) = $this->uploadPdf(
            $request,
            $volume,
            $editionNumber
        );
        $edition->cover = $coverPath;
        $edition->pdf = $pdfPath;
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
            'title' => 'required',
            'volume' => 'required|min:1',
            'edition' => 'required|min:1|max:3',
            'pdf' => 'file'
        ]);

        $volume = (int)$request->get('volume');
        $editionNumber = (int)$request->get('edition');

        list($cover, $pdf) = $request->hasFile('pdf')
            ? $this->uploadPdf($request, $volume, $editionNumber)
            : [$edition->cover(), $edition->pdf()];

        $edition->update([
            'title' => $request->input('title'),
            'volume' => $volume,
            'edition' => $editionNumber,
            'cover' => (string)$cover,
            'pdf' => (string)$pdf
        ]);

        return redirect('/admin/association/francken-vrij');
    }

    public function destroy(Edition $edition)
    {
        $edition->delete();

        return redirect('/admin/association/francken-vrij');
    }

    private function uploadPdf(Request $request, int $volume, int $edition) : array
    {
        /** @var Media */
        $franckenVrijMedia = $this->uploader->fromSource($request->file('pdf'))
            ->toDirectory('francken-vrij')
            ->useFilename($volume . '-' . $edition)
            ->setMaximumSize(self::ONE_HUNDRED_MB)
            ->upload();

        $coverMedia = $this->generateCoverMedia(
            $request,
            $volume,
            $edition,
            $franckenVrijMedia
        );

        return [
            new Url($coverMedia->getUrl()),
            new Url($franckenVrijMedia->getUrl())
        ];
    }

    private function generateCoverMedia(
        Request $request,
        int $volume,
        int $edition,
        Media $franckenVrijMedia
    ) : Media {
        /** @var string|UploadedFile */
        $cover_file = $request->hasFile('cover')
            ? $request->file('cover')
            : $this->generateCoverImageFromPdf(
                $franckenVrijMedia->getAbsolutePath()
            );

        return $this->uploader->fromSource($cover_file)
            ->toDirectory('francken-vrij/covers/')
            ->useFilename($volume . '-' . $edition . '-cover')
            ->setMaximumSize(self::ONE_HUNDRED_MB)
            ->upload();
    }

    private function generateCoverImageFromPdf(string $pdf_path) : string
    {
        $cover_path = preg_replace('"\.pdf$"', '-cover.png', $pdf_path);

        $imagick = new \Imagick();
        $imagick->setCompressionQuality(100);
        $imagick->setResolution(300, 300);
        $imagick->readImage($pdf_path . '[0]');
        $imagick->resizeImage(175, 245, \Imagick::FILTER_LANCZOS, 0.9);
        $imagick->transformImageColorspace(\Imagick::COLORSPACE_SRGB);
        $imagick->setFormat('png');
        $imagick->writeImage($cover_path);

        return $cover_path;
    }
}
