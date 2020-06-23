<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers\Admin;

use Francken\Association\FranckenVrij\Edition;
use Francken\Association\FranckenVrij\EditionId;
use Francken\Association\FranckenVrij\FranckenVrijRepository;
use Francken\Association\FranckenVrij\Volume;
use Francken\Shared\Http\Controllers\Controller;
use Francken\Shared\Url;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Plank\Mediable\Media;
use Plank\Mediable\MediaUploader;

final class FranckenVrijController extends Controller
{
    use ValidatesRequests;

    private const ONE_HUNDRED_MB = 100 * 1024 * 1024;

    private $franckenVrij;

    private $uploader;

    public function __construct(FranckenVrijRepository $franckenVrij, MediaUploader $uploader)
    {
        $this->franckenVrij = $franckenVrij;
        $this->uploader = $uploader;
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
            $volume,
            $edition
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
            ? $this->uploadPdf($request, $volume, $editionNumber)
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

    private function uploadPdf(Request $request, $volume, $edition)
    {
        $uploader = \App::make(MediaUploader::class);

        /** @var Media */
        $francken_vrij_media = $this->uploader->fromSource($request->file('pdf'))
            ->toDirectory('francken-vrij')
            ->useFilename($volume . '-' . $edition)
            ->setMaximumSize(self::ONE_HUNDRED_MB)
            ->upload();

        /** @var string|UploadedFile */
        $cover_file = $request->hasFile('cover')
            ? $request->file('cover')
            : $this->generateCoverImageFromPdf($francken_vrij_media->getAbsolutePath());

        /** @var Media */
        $cover_media = $this->uploader->fromSource($cover_file)
            ->toDirectory('francken-vrij/covers/')
            ->useFilename($volume . '-' . $edition . '-cover')
            ->setMaximumSize(self::ONE_HUNDRED_MB)
            ->upload();

        return [
            new Url($cover_media->getUrl()),
            new Url($francken_vrij_media->getUrl())
        ];
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
