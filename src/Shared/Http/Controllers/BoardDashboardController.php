<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use Francken\Shared\Http\Requests\BoardDashboardRequest;
use Illuminate\View\View;

class BoardDashboardController extends Controller
{
    public function index(BoardDashboardRequest $request) : View
    {
        $board = $request->board();
        $notifications = $board->notifications()->paginate(10);

        return view('admin.dashboard.board.index', [
            'board' => $board,
            'notifications' => $notifications,
            'total_notifications' => $board->notifications()->count(),
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Adtministration'],
            ]
        ]);
    }
}
