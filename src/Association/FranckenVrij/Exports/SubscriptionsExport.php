<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij\Exports;

use Illuminate\Support\Collection;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SubscriptionsExport implements FromView, ShouldAutoSize
{
    private Collection $subscriptions;

    public function __construct(Collection $subscriptions)
    {
        $this->subscriptions = $subscriptions;
    }

    public function view() : View
    {
        return view('admin.francken-vrij.subscriptions.export', [
            'subscriptions' => $this->subscriptions,
        ]);
    }
}
