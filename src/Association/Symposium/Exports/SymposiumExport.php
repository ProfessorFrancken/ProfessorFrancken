<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Exports;

use Francken\Association\Symposium\Participant;
use Francken\Association\Symposium\Symposium;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

final class SymposiumExport implements FromView //, FromCollection
{
    private Symposium $symposium;

    public function __construct(Symposium $symposium)
    {
        $this->symposium = $symposium;
    }

    // public function collection()
    // {
    //     // Participant::class;
    //     $symposium->load(['participants' => function ($query) {
    //         return $query->orderBy('lastname', 'asc');
    //     }]);
    //     return $symposium->participant;
    // }

    public function view() : View
    {
        $participants = $this->symposium->participants()
            ->orderBy('lastname', 'desc')
            ->where('is_spam', false)
            ->get();

        return view('admin.association.symposia.export', [
            'symposium' => $this->symposium,
            'participants' => $participants
        ]);
    }
}
