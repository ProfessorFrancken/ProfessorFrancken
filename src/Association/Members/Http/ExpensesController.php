<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http;

use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Webmozart\Assert\Assert;

final class ExpensesController
{
    public function index(Request $request) : View
    {
        $member = $request->user()->member;
        $id = $member->id;

        $transactions = \DB::connection('francken-legacy')->table('transacties')
            ->join('producten', 'transacties.product_id', '=', 'producten.id')
            ->orderBy('tijd', 'desc')
            ->where('lid_id', $id)
            ->limit(100)
            ->get()
            ->map(function ($transaction) : array {
                $name = $transaction->naam;

                if ($transaction->aantal > 1) {
                    $name .= ' (' . $transaction->aantal . ')';
                }

                return [
                    'time' => $transaction->tijd,
                    'product' => $name,
                    'price' => $transaction->prijs
                ];
            });

        $perMonth = DB::connection('francken-legacy')->table('transacties')
            ->select([
                'tijd',
                'lid_id',
                DB::raw('sum(prijs) as price'),
                DB::raw('YEAR(tijd) year, MONTH(tijd) month')
            ])
            ->orderBy('tijd', 'desc')
            ->where('lid_id', $id)
            ->limit(100)
            ->groupby('year', 'month')
            ->get()
            ->map(fn ($month) : array => [
                "time" => new DateTimeImmutable($month->tijd),
                "price" => $month->price
            ]);

        return view('profile.expenses.index')
            ->with([
                'member' => $member,
                'transactions' => $transactions,
                'perMonth' => $perMonth,
                'breadcrumbs' => [
                    ['url' => '/profile', 'text' => 'Profile'],
                    ['url' => '/profile/expenses', 'text' => 'Expenses'],
                ],
            ]);
    }

    public function show(string $year, string $month, Request $request) : View
    {
        $member = $request->user()->member;
        $id = $member->id;

        $deductions = DB::connection('francken-legacy')
                ->table('afschrijvingen')
                ->orderBy('tijd', 'desc')
                ->get()
                ->map(fn ($deduction) : DateTimeImmutable => new DateTimeImmutable($deduction->tijd));

        $transactions = DB::connection('francken-legacy')->table('transacties')
            ->join('producten', 'transacties.product_id', '=', 'producten.id')
            ->orderBy('tijd', 'desc')
            ->where('lid_id', $id)
            ->whereYear('tijd', $year)
            ->whereMonth('tijd', $month)
            ->get()
            ->map(function ($transaction) use ($deductions) : array {
                $name = $transaction->naam;

                if ($transaction->aantal > 1) {
                    $name .= ' (' . $transaction->aantal . ')';
                }

                $time = new DateTimeImmutable($transaction->tijd);

                // Find the date this transaction was deducted on
                $deductedAt = $deductions->reduce(fn ($current, $next) => $time < $next ? $next->format('Y-m-d') : $current, null);

                return [
                    'time' => $time,
                    'product' => $name,
                    'price' => $transaction->totaalprijs,
                    'deducted_at' => $deductedAt
                ];
            });


        $byDay = $transactions->groupBy(fn ($transaction) => $transaction['time']->format('d'));

        $date = DateTimeImmutable::createFromFormat("Y-m", "$year-$month");
        Assert::isInstanceOf($date, DateTimeImmutable::class);

        return view('profile.expenses.show')
            ->with([
                'member' => $member,
                'byDay' => $byDay,
                'date' => $date->format('F Y'),
                'breadcrumbs' => [
                    ['url' => '/profile', 'text' => 'Profile'],
                    ['url' => '/profile/expenses', 'text' => 'Expenses'],
                    ['text' => $date->format('F Y')],
                ],
            ]);
    }
}
