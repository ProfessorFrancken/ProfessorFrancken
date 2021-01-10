<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Http;

use DateTimeImmutable;
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

    public function store(Request $request) : RedirectResponse
    {
        $openForRegistration = $request->has('open_for_registration');
        $promoteOnAgenda = $request->has('promote_on_agenda');

        $symposium = Symposium::create([
            'name' => $request->input('name'),
            'start_date' => new DateTimeImmutable($request->input('start_date')),
            'end_date' => new DateTimeImmutable($request->input('end_date')),
            'location' => $request->input('location'),
            'website_url' => $request->input('website_url'),
            'open_for_registration' => $openForRegistration,
            'promote_on_agenda' => $promoteOnAgenda,
        ]);

        return redirect()->action([self::class, 'show'], $symposium->id);
    }

    public function show(Symposium $symposium) : View
    {
        $symposium->load(['participants' => fn ($query) => $query->orderBy('id', 'desc')]);

        return view('admin.association.symposia.show', [
            'symposium' => $symposium,
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

    public function update(Symposium $symposium, Request $request) : RedirectResponse
    {
        $openForRegistration = $request->has('open_for_registration');
        $promoteOnAgenda = $request->has('promote_on_agenda');

        $symposium->update([
            'name' => $request->input('name'),
            'start_date' => new DateTimeImmutable($request->input('start_date')),
            'end_date' => new DateTimeImmutable($request->input('end_date')),
            'location' => $request->input('location'),
            'website_url' => $request->input('website_url'),
            'open_for_registration' => $openForRegistration,
            'promote_on_agenda' => $promoteOnAgenda,
        ]);

        return redirect()->action([self::class, 'show'], $symposium->id);
    }
}
