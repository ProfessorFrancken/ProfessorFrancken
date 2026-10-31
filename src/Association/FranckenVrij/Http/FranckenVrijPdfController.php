<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij\Http;

use Francken\Association\FranckenVrij\Edition;
use Francken\Shared\Http\Controllers\Controller;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Webmozart\Assert\Assert;

final class FranckenVrijPdfController extends Controller
{
    public function show(Edition $edition) : StreamedResponse
    {
        $disk = Storage::disk('francken-vrij');
        Assert::isInstanceOf($disk, FilesystemAdapter::class);
        $filename = $edition->pdfFilename();

        abort_unless($disk->exists($filename), 404);

        return $disk->response(
            $filename,
            sprintf('Francken Vrij %d.%d.pdf', $edition->volume(), $edition->edition()),
            ['Cache-Control' => 'private']
        );
    }
}
