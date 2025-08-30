<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Controllers;

use Francken\Treasurer\DeductionEmail;
use Francken\Treasurer\DeductionEmailToMember;
use Francken\Treasurer\Http\Requests\DeductionRequest;
use Francken\Treasurer\Imports\ImportDeductions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Maatwebsite\Excel\Importer;
use Plank\Mediable\Media;
use Plank\Mediable\MediaUploader;

final class DeductionsController
{
    private Importer $importer;

    public function __construct(Importer $importer)
    {
        $this->importer = $importer;
    }

    public function index() : View
    {
        $deductions = DeductionEmail::orderBy('deducted_at', 'desc')
            ->with('deductionToMembers')
            ->paginate(15);

        return view('admin.treasurer.deductions.index', [
            'deductions' => $deductions,
            'deduction' => new DeductionEmail(),
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Deductions'],
            ]
        ]);
    }

    public function create() : RedirectResponse
    {
        return redirect()->action([static::class, 'index']);
    }

    public function store(DeductionRequest $request, MediaUploader $uploader) : RedirectResponse
    {
        /** @var Media */
        $deductionFile = $uploader->fromSource($request->deduction())
            ->setAllowUnrecognizedTypes(true)
            ->toDestination('local', 'deductions')
            ->useHashForFilename()
            ->upload();

        $deduction = DeductionEmail::upload(
            $deductionFile,
            $request->deductedAt(),
            $request->deductionFrom(),
            $request->deductionTo(),
            $this->importer
        );

        return redirect()->action([self::class, 'show'], $deduction->id);
    }

    public function show(DeductionEmail $deduction) : View
    {
        $deduction->load([
            'deductionToMembers',
            'deductionToMembers.member'
        ]);

        $members = $deduction->deductionToMembers
            ->sortBy(function (DeductionEmailToMember $deduction) : string {
                return $deduction->member->achternaam;
            });

        $conflicts = $this->findConflicts($deduction, $members);

        return view('admin.treasurer.deductions.show', [
            'deduction' => $deduction,
            'deductions' => $members,
            'conflicts' => $conflicts,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Deductions'],
                ['url' => action([static::class, 'show'], $deduction->id), 'text' => $deduction->deducted_at->format('Y-m-d')],
            ]
        ]);
    }

    public function update(Request $request, DeductionEmail $deduction) : RedirectResponse //, MailDeduction $deduction)
    {
        if ($request->input('action', '') === 'resolve-conflict') {
            $deduction->update(['was_verified' => true]);
        }

        return redirect()->action([self::class, 'show'], $deduction->id);
    }

    /**
     * Find all deductions that had conflicts and return a collection that contains
     * the type of conflict for each member
     */
    private function findConflicts(DeductionEmail $deduction, Collection $members) : Collection
    {
        // We don't need to show conflicts if this deduction was already verified
        // or if no conflicts were found
        if ($deduction->was_verified || $members->where('contained_errors')->isEmpty()) {
            return new Collection();
        }

        $import = new ImportDeductions();
        $this->importer->import(
            $import,
            $deduction->deductionFile->getDiskPath(),
            $deduction->deductionFile->disk
        );

        return $import->errors()->reject(function (Collection $errors) : bool {
            return $errors->isEmpty();
        });
    }
}
