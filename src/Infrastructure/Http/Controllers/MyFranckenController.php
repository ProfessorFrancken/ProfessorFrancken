<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use Illuminate\View\Factory as View;
use DateTimeImmutable;

final class MyFranckenController
{
    private $profile;

    public function __construct(View $view)
    {
        $id = 1403;

        $lid = \DB::connection('francken-legacy')->table('leden')->where('id', $id)->first();
        $this->profile = $lid;

        $view->share('profile', $lid);
    }

    public function index()
    {
        return view('my-francken.index');
    }

    public function profile()
    {

        return view('my-francken.profile');
    }

    public function settings()
    {
        return view('my-francken.settings');
    }

    public function members()
    {
        return view('my-francken.members');
    }

    public function committees()
    {
        return view('my-francken.committees');
    }

    public function activities()
    {
        return view('my-francken.activities');
    }

    public function finances()
    {
        $id = $this->profile->id;

        $transactions = \DB::connection('francken-legacy')->table('transacties')
            ->join('producten', 'transacties.product_id', '=', 'producten.id')
            ->orderBy('tijd', 'desc')
            ->where('lid_id', $id)
            ->limit(100)
            ->get()
            ->map(function ($transaction) {
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

        $perMonth = \DB::connection('francken-legacy')->table('transacties')
            ->select(
                'tijd',
                'lid_id',
                \DB::raw('count(prijs) as price'),
                \DB::raw('YEAR(tijd) year, MONTH(tijd) month')
            )
            ->orderBy('tijd', 'desc')
            ->where('lid_id', $id)
            ->limit(100)
            ->groupby('year','month')
            ->get()
            ->map(function($month) {
                return [
                    "time" => new DateTimeImmutable($month->tijd),
                    "price" => $month->price
                ];
            });

        return view('my-francken.finances')
            ->with([
                'transactions' => $transactions,
                'perMonth' => $perMonth
                ]);
    }

    public function financesInMonth($year, $month)
    {
        $id = $this->profile->id;

        $deductions = \DB::connection('francken-legacy')
                ->table('afschrijvingen')
                ->orderBy('tijd', 'desc')
                ->get()
                ->map(function ($deduction) {
                    return new \DateTimeImmutable($deduction->tijd);
                });

        $transactions = \DB::connection('francken-legacy')->table('transacties')
            ->join('producten', 'transacties.product_id', '=', 'producten.id')
            ->orderBy('tijd', 'desc')
            ->where('lid_id', $id)
            ->whereYear('tijd', $year)
            ->whereMonth('tijd', $month)
            ->get()
            ->map(function ($transaction) use ($deductions) {
                $name = $transaction->naam;

                if ($transaction->aantal > 1) {
                    $name .= ' (' . $transaction->aantal . ')';
                }

                $time = new DateTimeImmutable($transaction->tijd);

                // Find the date this transaction was deducted on
                $deductedAt = $deductions->reduce(function ($current, $next) use ($time) {
                    return $time < $next ? $next->format('Y-m-d') : $current;
                }, null);

                return [
                    'time' => $time,
                    'product' => $name,
                    'price' => $transaction->prijs,
                    'deducted_at' => $deductedAt
                ];
            });


        $byDay = $transactions->groupBy(function ($transaction) {
            return $transaction['time']->format('d');
        });

        return view('my-francken.finances-in-month')
            ->with([
                'byDay' => $byDay,
                'date' => (DateTimeImmutable::createFromFormat("Y-m", "$year-$month"))->format('F Y')
            ]);
    }

    public function adtcievements()
    {
        return view('my-francken.adtcievements');
    }
}
