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
        $notifications = $board->unreadNotifications()->paginate(20);

        return view('admin.dashboard.board.index', [
            'board' => $board,
            'notifications' => $notifications,
            'total_notifications' => $board->unreadNotifications()->count(),
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Adtministration'],
            ]
        ]);
    }
}
