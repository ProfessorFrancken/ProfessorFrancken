<?php

declare(strict_types=1);

namespace Francken\Association\AlumniActivity\Http;

use Francken\Association\AlumniActivity\Alumnus;
use Illuminate\View\View;

final class AlumniActivityController
{
    public function index() : View
    {
        $alumni = Alumnus::orderBy('fullname', 'asc')->get();

        return view('association.alumni-activity.index', [
            'alumni' => $alumni,
            'breadcrumbs' => [
                ['url' => '/association/', 'text' => 'Association'],
                ['url' => action([self::class, 'index']), 'text' => 'Alumni activity 2022'],
            ]
        ]);
    }
}
