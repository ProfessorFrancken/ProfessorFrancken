<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Controllers;

use DateTimeImmutable;
use Francken\Treasurer\Deduction;
use Francken\Treasurer\Exports\TransactionsExport;
use Francken\Treasurer\Http\Requests\AdminTransactionsExportRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class AdminTransactionsExportsController
{
    public function index(AdminTransactionsExportRequest $request) : View
    {
        $deductions = Deduction::orderBy('tijd', 'desc')->paginate(15);
        $lastDeduction = Deduction::orderBy('tijd', 'desc')->first();

        return view('admin.treasurer.transactions.exports.index')
            ->with([
                'request' => $request,
                'deductions' => $deductions,
                'lastDeduction' => $lastDeduction,
                'breadcrumbs' => [
                    ['url' => action([AdminTransactionsController::class, 'index']), 'text' => 'Transactions'],
                    ['url' => action([self::class, 'index']), 'text' => 'Exports'],
                ]
            ]);
    }

    public function create(AdminTransactionsExportRequest $request) : View
    {
        return view('admin.treasurer.transactions.exports.create')
            ->with([
                'request' => $request,
                'breadcrumbs' => [
                    ['url' => action([AdminTransactionsController::class, 'index']), 'text' => 'Transactions'],
                    ['url' => action([self::class, 'index']), 'text' => 'Exports'],
                    ['url' => action([self::class, 'create']), 'text' => 'Create'],
                ]
            ]);
    }


    public function show(Deduction $deduction) : View
    {
        $lastDeduction = Deduction::orderBy('tijd', 'desc')->first();

        $previousDeduction = $deduction->previousDeduction();
        $transactions = $this->getTransactionReport(
            $previousDeduction->tijd->toDateTimeImmutable(),
            $deduction->tijd->toDateTimeImmutable()
        );

        return view('admin.treasurer.transactions.exports.show')
            ->with([
                'deduction' => $deduction,
                'previousDeduction' => $previousDeduction,
                'transactions' => $transactions,
                'canEdit' => $deduction->id === $lastDeduction->id,
                'breadcrumbs' => [
                    ['url' => action([AdminTransactionsController::class, 'index']), 'text' => 'Transactions'],
                    ['url' => action([self::class, 'index']), 'text' => 'Exports'],
                    [
                        'url' => action([self::class, 'show'], ['deduction' => $deduction]),
                        'text' => sprintf("%s - %s", $previousDeduction->tijd->format("Y-m-d H:i:s"), $deduction->tijd->format("Y-m-d H:i:s"))
                    ],
                ]
            ]);
    }

    public function store(AdminTransactionsExportRequest $request) : RedirectResponse
    {
        $deduction = Deduction::create(['tijd' => $request->until()]);
        return redirect()->action([self::class, 'show'], ['deduction' => $deduction]);
    }

    public function edit(Deduction $deduction) : View
    {
        $previousDeduction = $deduction->previousDeduction();

        return view('admin.treasurer.transactions.exports.edit')
            ->with([
                'deduction' => $deduction,
                'previousDeduction' => $previousDeduction,
                'breadcrumbs' => [
                    ['url' => action([AdminTransactionsController::class, 'index']), 'text' => 'Transactions'],
                    ['url' => action([self::class, 'index']), 'text' => 'Exports'],
                    [
                        'url' => action([self::class, 'show'], ['deduction' => $deduction]),
                        'text' => sprintf("%s - %s", $previousDeduction->tijd->format("Y-m-d H:i:s"), $deduction->tijd->format("Y-m-d H:i:s"))
                    ],
                    ['url' => action([self::class, 'edit'], ['deduction' => $deduction]), 'text' => 'Edit'],
                ]
            ]);
    }

    public function update(Deduction $deduction, AdminTransactionsExportRequest $request) : RedirectResponse
    {
        $deduction->tijd = $request->until();
        $deduction->save();

        return redirect()->action([self::class, 'show'], ['deduction' => $deduction]);
    }

    public function export(Deduction $deduction) : BinaryFileResponse
    {
        $previousDeduction = $deduction->previousDeduction();
        $transactions = $this->getTransactionReport(
            $previousDeduction->tijd->toDateTimeImmutable(),
            $deduction->tijd->toDateTimeImmutable()
        );

        return Excel::download(
            new TransactionsExport($transactions),
            sprintf("frankcen-transactions-%s-%s.csv", $previousDeduction->tijd->format('Y-m-d'), $deduction->tijd->format('Y-m-d'))
        );
    }

    public function destroy(Deduction $deduction) : RedirectResponse
    {
        $deduction->delete();

        return redirect()->action([self::class, 'index']);
    }

    private function getTransactionReport(DateTimeImmutable $from, DateTimeImmutable $until)
    {
        return DB::connection('francken-legacy')
            ->table('transacties')
            ->join('leden', 'leden.id', '=', 'transacties.lid_id')
            ->orderBy('leden.achternaam', 'asc')
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
                DB::raw('sum(transacties.totaalprijs) AS totale_kosten')
            ])
            ->groupBy([
                'leden.id',
                'leden.initialen',
                'leden.tussenvoegsel',
                'leden.achternaam',
                'leden.rekeningnummer',
                'leden.plaats_bank',
                'leden.adres',
                'leden.plaats',
                'leden.land',
                'leden.start_lidmaatschap'
            ])
            ->whereBetween('transacties.tijd', [$from->format('Y-m-d H:i:s'), $until->format('Y-m-d H:i:s')])
            ->get();
    }
}
