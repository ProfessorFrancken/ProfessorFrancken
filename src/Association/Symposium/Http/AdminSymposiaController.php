<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Http;

use Francken\Association\Symposium\FileUploader;
use Francken\Association\Symposium\Http\Requests\SymposiumRequest;
use Francken\Association\Symposium\Symposium;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class AdminSymposiaController
{
    public function index() : View
    {
        $symposia = Symposium::orderBy('start_date', 'DESC')
            ->withCount(['participants' => function ($query) : void {
                $query->where('is_spam', false);
            }])
            ->with(['logoMedia'])
            ->paginate(10);

        return view('admin.association.symposia.index', [
            'symposia' => $symposia,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Symposia'],
            ]
        ]);
    }

    public function create() : View
    {
        return view('admin.association.symposia.create', [
            'symposium' => new Symposium(),
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Symposia'],
                ['url' => action([static::class, 'create']), 'text' => 'Add'],
            ]
        ]);
    }

    public function store(SymposiumRequest $request, FileUploader $uploader) : RedirectResponse
    {
        $symposium = Symposium::create([
            'name' => $request->name(),
            'start_date' => $request->startDate(),
            'end_date' => $request->endDate(),
            'location' => $request->location(),
            'location_google_maps_url' => $request->locationGoogleMapsUrl(),
            'website_url' => $request->websiteUrl(),
            'open_for_registration' => $request->openForRegistration(),
            'promote_on_agenda' => $request->promoteOnAgenda(),
        ]);

        $uploader->uploadLogo($request->logo, $symposium);

        return redirect()->action([self::class, 'show'], $symposium->id);
    }

    public function show(Request $request, Symposium $symposium) : View
    {
        $symposium->load(['participants' => fn ($query) => $query->orderBy('id', 'desc')]);

        return view('admin.association.symposia.show', [
            'symposium' => $symposium,
            'show_spam' => $request->has('show_spam'),
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Symposia'],
                ['url' => action([static::class, 'show'], $symposium->id), 'text' => $symposium->name],
            ]
        ]);
    }

    public function edit(Symposium $symposium) : View
    {
        return view('admin.association.symposia.edit', [
            'symposium' => $symposium,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Symposia'],
                ['url' => action([static::class, 'show'], $symposium->id), 'text' => $symposium->name],
                ['url' => action([static::class, 'edit'], $symposium->id), 'text' => 'edit'],
            ]
        ]);
    }

    public function update(Symposium $symposium, SymposiumRequest $request, FileUploader $uploader) : RedirectResponse
    {
        $symposium->update([
            'name' => $request->name(),
            'start_date' => $request->startDate(),
            'end_date' => $request->endDate(),
            'location' => $request->location(),
            'location_google_maps_url' => $request->locationGoogleMapsUrl(),
            'website_url' => $request->websiteUrl(),
            'open_for_registration' => $request->openForRegistration(),
            'promote_on_agenda' => $request->promoteOnAgenda(),
        ]);

        if ($request->hasFile('logo')) {
            $uploader->uploadLogo($request->logo, $symposium);
        }

        return redirect()->action([self::class, 'show'], $symposium->id);
    }
}
