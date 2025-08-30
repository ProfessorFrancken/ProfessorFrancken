<?php

declare(strict_types=1);

namespace Francken\Treasurer\Exports;

use Illuminate\Support\Collection;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionsExport implements FromView, ShouldAutoSize
{
    private Collection $transactions;

    public function __construct(Collection $transactions)
    {
        $this->transactions = $transactions;
    }

    public function view() : View
    {
        return view('admin.treasurer.transactions.exports.export', [
            'transactions' => $this->transactions,
        ]);
    }
}
