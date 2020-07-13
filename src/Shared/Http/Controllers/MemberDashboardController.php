<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberDashboardController extends Controller
{
    public function index(Request $request) : View
    {
        return view('admin.dashboard.member.index', [
            'member' => $request->user()->member,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Adtministration'],
            ]
        ]);
    }
}
