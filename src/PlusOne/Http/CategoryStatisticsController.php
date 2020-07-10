<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use DateInterval;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class CategoryStatisticsController
{
    public function index(Request $request) : array
    {
        // By default use the period between today and 6 months ago
        $endDate = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $request->get('endDate', (new DateTimeImmutable())->format('Y-m-d'))
        );

        $startDate = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $request->get('startDate', $endDate->sub(new DateInterval('P6M'))->format('Y-m-d'))
        );

        $stats = DB::connection('francken-legacy')
            ->table('transacties')
            ->orderBy('tijd', 'desc')
            ->join('producten', 'transacties.product_id', '=', 'producten.id')
            ->select([
                DB::raw('sum(aantal) as amount'),
                'categorie',
                DB::raw('DATE_FORMAT(DATE_SUB(tijd, INTERVAL 6 HOUR), "%Y-%m-%d") as date'),
            ])
            ->groupBy('date', 'categorie')
            ->where('lid_id', '<>', 1098) // filter out Guests
            ->whereBetween('tijd', [$startDate, $endDate])
            ->get();

        return [
            'statistics' => $stats->groupBy(function ($statistic) {
                return $statistic->date;
            })->map(function ($statByDate, $date) : array {
                // For each date we probably have a category for beer, soda and food unless said category
                // wasn't purchased that day
                $beer = $statByDate->first(function ($stat) : bool {
                    return 'Bier' === $stat->categorie;
                });
                $soda = $statByDate->first(function ($stat) : bool {
                    return 'Fris' === $stat->categorie;
                });
                $food = $statByDate->first(function ($stat) : bool {
                    return 'Eten' === $stat->categorie;
                });

                return [
                    'date' => $date,
                    'beer' => $beer ? $beer->amount : 0,
                    'soda' => $soda ? $soda->amount : 0,
                    'food' => $food ? $food->amount : 0,
                ];
            })->values(),
        ];
    }
}
