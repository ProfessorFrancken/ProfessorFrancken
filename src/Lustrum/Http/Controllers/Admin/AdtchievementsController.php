<?php

declare(strict_types=1);

namespace Francken\Lustrum\Http\Controllers\Admin;

use Francken\Lustrum\Adtchievement;
use Illuminate\Http\Request;

class AdtchievementsController
{
    public function index()
    {
        $adtchievements = Adtchievement::all();

        return view('lustrum.admin.adtchievements.index')
            ->with([
                'adtchievements' => $adtchievements,
                'breadcrumbs' => [
                    ['url' => '/lustrum', 'text' => 'Lustrum'],
                    [
                        'url' => action([self::class, 'index']),
                        'text' => 'Adtchievements'
                    ],
                ]
            ]);
    }

    public function create()
    {
        return view('lustrum.admin.adtchievements.create', [
            'adtchievement' => new Adtchievement(),
            'breadcrumbs' => [
                ['url' => '/lustrum', 'text' => 'Lustrum'],
                ['url' => action([self::class, 'index']), 'text' => 'Adtchievements'],
                ['url' => action([self::class, 'create']), 'text' => 'Add'],
            ]
        ]);
    }

    public function edit(Adtchievement $adtchievement)
    {
        return view('lustrum.admin.adtchievements.edit', [
            'adtchievement' => $adtchievement,
            'breadcrumbs' => [
                ['url' => '/lustrum', 'text' => 'Lustrum'],
                ['url' => action([self::class, 'index']), 'text' => 'Adtchievements'],
                ['url' => action([self::class, 'edit'], $adtchievement->id), 'text' => $adtchievement->title],
            ]
        ]);
    }

    public function store(Request $request)
    {
        $adtchievement = Adtchievement::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'points' => $request->input('points'),
            'is_repeatable' => $request->has('is_repeatable'),
            'is_team_effort' => $request->has('is_team_effort'),
            'is_hidden' => $request->has('is_hidden'),
        ]);


        return redirect()->action([self::class, 'index']);
    }


    public function update(Adtchievement $adtchievement, Request $request)
    {
        $adtchievement = $adtchievement->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'points' => $request->input('points'),
            'is_repeatable' => $request->has('is_repeatable'),
            'is_team_effort' => $request->has('is_team_effort'),
            'is_hidden' => $request->has('is_hidden'),
        ]);


        return redirect()->action([self::class, 'index']);
    }
}
