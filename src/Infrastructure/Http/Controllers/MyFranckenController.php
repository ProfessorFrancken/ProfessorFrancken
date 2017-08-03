<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

final class MyFranckenController
{

    public function index()
    {
        return view('my-francken.index');
    }

    public function profile()
    {
        return view('my-francken.profile');
    }

    public function settings()
    {
        return view('my-francken.settings');
    }

    public function members()
    {
        return view('my-francken.members');
    }

    public function committees()
    {
        return view('my-francken.committees');
    }

    public function activities()
    {
        return view('my-francken.activities');
    }

    public function canteen()
    {
        return view('my-francken.canteen');
    }

    public function adtcievements()
    {
        return view('my-francken.adtcievements');
    }
}
