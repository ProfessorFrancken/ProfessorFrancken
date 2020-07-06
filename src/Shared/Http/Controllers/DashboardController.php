<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use Francken\Association\Boards\Board;

class DashboardController extends Controller
{
    public function redirectToDashboard()
    {
        return redirect('/admin/overview');
    }

    public function overview()
    {
        $board = Board::current()->firstOrFail();

        return view('admin.overview', [
            'board' => $board,
            'breadcrumbs' => [
                ['url' => action([self::class, 'overview']), 'text' => 'Adtministration'],
            ]
        ]);
    }
}
