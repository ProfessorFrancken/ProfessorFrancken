<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use Francken\Association\Boards\Board;
use Francken\Association\Boards\BoardMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function redirectToDashboard(Request $request) : RedirectResponse
    {
        $account = $request->user();
        $isBoardMember = Board::current()->firstOrFail()
            ->members
            ->contains(fn (BoardMember $member) => $member->member_id === $account->member_id);

        if ($isBoardMember) {
            return redirect()->action([BoardDashboardController::class, 'index']);
        }

        return redirect()->action([MemberDashboardController::class, 'index']);
    }
}
