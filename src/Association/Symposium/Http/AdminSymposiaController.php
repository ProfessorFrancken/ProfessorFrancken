<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Http;

use DateTimeImmutable;
use Francken\Association\Symposium\Symposium;
use Illuminate\Http\Request;

final class AdminSymposiaController
{
    public function index()
    {
        $symposia = Symposium::orderBy('start_date', 'DESC')
            ->withCount('participants')
            ->paginate(10);

        return view('admin.association.symposia.index', [
            'symposia' => $symposia,
            'news' => [],
        ]);
    }

    public function create()
    {
        return view('admin.association.symposia.create', [
            'symposium' => new Symposium(),
        ]);
    }

    public function store(Request $request)
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
        return view('admin.association.symposia.show', [
            'symposium' => $symposium,
        ]);
    }

    public function edit(Symposium $symposium)
    {
        return view('admin.association.symposia.edit', [
            'symposium' => $symposium,
        ]);
    }

    public function update(Symposium $symposium, Request $request)
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
