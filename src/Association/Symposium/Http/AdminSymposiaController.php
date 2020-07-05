<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Http;

use Illuminate\Http\RedirectResponse;
use DateTimeImmutable;
use Francken\Association\Symposium\Symposium;
use Illuminate\Http\Request;

final class AdminSymposiaController
{
    public function index()
    {
        $symposia = Symposium::orderBy('start_date', 'DESC')
            ->withCount(['participants' => function ($query) : void {
                $query->where('is_spam', false);
            }])
            ->paginate(10);

        return view('admin.association.symposia.index', [
            'symposia' => $symposia,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Symposia'],
            ]
        ]);
    }

    public function create()
    {
        return view('admin.association.symposia.create', [
            'symposium' => new Symposium(),
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Symposia'],
                ['url' => action([static::class, 'create']), 'text' => 'Add'],
            ]
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $open_for_registration = $request->has('open_for_registration');
        $promote_on_agenda = $request->has('promote_on_agenda');

        $symposium = Symposium::create([
            'name' => $request->input('name'),
            'start_date' => new DateTimeImmutable($request->input('start_date')),
            'end_date' => new DateTimeImmutable($request->input('end_date')),
            'location' => $request->input('location'),
            'website_url' => $request->input('website_url'),
            'open_for_registration' => $open_for_registration,
            'promote_on_agenda' => $promote_on_agenda,
        ]);

        return redirect()->action([self::class, 'show'], $symposium->id);
    }

    public function show(Symposium $symposium)
    {
        $symposium->load(['participants' => function ($query) {
            return $query->orderBy('id', 'desc');
        }]);

        return view('admin.association.symposia.show', [
            'symposium' => $symposium,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Symposia'],
                ['url' => action([static::class, 'show'], $symposium->id), 'text' => $symposium->name],
            ]
        ]);
    }

    public function edit(Symposium $symposium)
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

    public function update(Symposium $symposium, Request $request): RedirectResponse
    {
        $open_for_registration = $request->has('open_for_registration');
        $promote_on_agenda = $request->has('promote_on_agenda');

        $symposium->update([
            'name' => $request->input('name'),
            'start_date' => new DateTimeImmutable($request->input('start_date')),
            'end_date' => new DateTimeImmutable($request->input('end_date')),
            'location' => $request->input('location'),
            'website_url' => $request->input('website_url'),
            'open_for_registration' => $open_for_registration,
            'promote_on_agenda' => $promote_on_agenda,
        ]);

        return redirect()->action([self::class, 'show'], $symposium->id);
    }
}
