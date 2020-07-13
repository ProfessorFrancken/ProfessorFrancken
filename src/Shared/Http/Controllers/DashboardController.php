<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use Francken\Association\Boards\Board;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function redirectToDashboard() : RedirectResponse
    {
        return redirect('/admin/overview');
    }

    public function overview() : View
    {
        $board = Board::current()->firstOrFail();

        return view('admin.overview', [
            'board' => $board,
            'notifications' => $board->notifications,
            'breadcrumbs' => [
                ['url' => action([self::class, 'overview']), 'text' => 'Adtministration'],
            ]
        ]);
    }
}
