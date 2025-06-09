<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Controllers;

use Francken\Shared\Clock\Clock;
use Francken\Treasurer\Exports\TransactionsExport;
use Francken\Treasurer\Http\Requests\AdminTransactionsExportRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class AdminTransactionsExportsController
{
    public function create(AdminTransactionsExportRequest $request) : View
    {
        return view('admin.treasurer.transactions.exports.create')
            ->with([
                'request' => $request,
                'breadcrumbs' => [
                    ['url' => action([AdminTransactionsController::class, 'index']), 'text' => 'Transactions'],
                    ['url' => action([self::class, 'create']), 'text' => 'Export transactions'],
                ]
            ]);
    }

    public function store(AdminTransactionsExportRequest $request, Clock $clock) : BinaryFileResponse
    {
        $transactions = DB::connection('francken-legacy')
                ->table('transacties')
                ->join('leden', 'leden.id', '=', 'transacties.id')
                ->orderBy('transacties.tijd', 'desc')
                ->select([
                    'leden.id as id',
                    'leden.initialen as initialen',
                    'leden.tussenvoegsel as tussenvoegsel',
                    'leden.achternaam as achternaam',
                    'leden.rekeningnummer as rekeningnummer',
                    'leden.plaats_bank as plaats_bank',
                    'leden.adres as adres',
                    'leden.plaats as plaats',
                    'leden.land as land',
                    'leden.start_lidmaatschap as start_lidmaatschap',
                    //'transacties.totaalprijs',
                    DB::raw('sum(transacties.totaalprijs) AS totale_kosten')
                ])
                ->groupBy([
                    'leden.initialen',
                    'leden.tussenvoegsel',
                    'leden.achternaam',
                    'leden.rekeningnummer',
                    'leden.plaats_bank',
                ])
                ->whereBetween('transacties.tijd', [
                    $request->from(),
                    $request->until()
                ])
                ->get();


        return Excel::download(
            new TransactionsExport($transactions),
            sprintf("frankcen-transactions-%s-%s.xlsx", $request->from()?->format('Y-m-d'), $request->until()?->format('Y-m-d'))
        );
    }
}
