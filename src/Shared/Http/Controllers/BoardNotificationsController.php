<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\DatabaseNotification;

class BoardNotificationsController extends Controller
{
    public function destroy(DatabaseNotification $notification) : RedirectResponse
    {
        $notification->markAsRead();

        return redirect()->action([BoardDashboardController::class, 'index']);
    }
}
