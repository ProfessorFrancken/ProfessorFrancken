<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij\Http;

use Francken\Association\FranckenVrij\Exports\SubscriptionsExport;
use Francken\Association\FranckenVrij\Subscription;
use Francken\Shared\Clock\Clock;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class AdminSubscriptionsExportController
{
    public function index(Clock $clock) : BinaryFileResponse
    {
        $today = $clock->now();
        $subscriptions = Subscription::withActiveSubscription($today)->with(['member'])->get();

        return Excel::download(
            new SubscriptionsExport($subscriptions),
            sprintf("francken-vrij-subscriptions-%s.xlsx", $today->format('Y-m-d'))
        );
    }
}
