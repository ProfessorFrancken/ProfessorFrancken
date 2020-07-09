<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Carbon\Carbon;
use DateInterval;
use DateTimeImmutable;
use DB;
use Francken\Extern\FactSheet\ActiveMembersStatistics;
use Francken\Extern\FactSheet\FirstYearStudentsPerYear;
use Francken\Extern\FactSheet\StudentsByStudyAndStudyPhase;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use League\Period\Period;

final class FactSheetController
{
    private DateTimeImmutable $today;

    public function __construct()
    {
        $this->today = new DateTimeImmutable();
    }

    public function index() : View
    {
        // Use preseneters to decorate the dispatched queries?
        // use iterators instead?
        // new GroupByStudy( // StudyStatistics
        // new FirstYearStudentsOfYear(
        // new PerYearIterator($years)
        // )
        // )
        // new StudentsPerStudyAndYear
        return view('admin.extern.fact-sheet.index')
            ->with([
                'studies' => (new StudentsByStudyAndStudyPhase($this->today))->handle(),
                'activeMembers' => (new ActiveMembersStatistics($this->today))->handle(),
                'firstYearStudentsPerYear' => (new FirstYearStudentsPerYear(collect(range(2011, 2018))))->handle(),
                'weeklyStats' => $this->weeklyStats(),
                'monthlyStats' => $this->monthlyStats(),
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Factsheet'],
                ]
            ]);
    }

    private function weeklyStats() : Collection
    {
        $today = new DateTimeImmutable('now');
        $lastWeek = $today->sub(new DateInterval('P7D'));

        $today = Carbon::now();
        $lastWeek = Carbon::now()->subWeeks(1);

        return collect(range(0, 24))->map(function ($weeksBeforeToday) : array {
            $target = Carbon::now()->subWeeks($weeksBeforeToday);
            return [
                'week' => (int)$target->format('W'),
                'stats' => $this->transactionsDuringWeek(
                    (int)$target->format('Y'),
                    (int)$target->format('W')
                )
            ];
        });
    }

    private function monthlyStats() : Collection
    {
        return collect(range(0, 12 * 4))->map(function ($weeksBeforeToday) : array {
            $target = Carbon::now()->subMonths($weeksBeforeToday);
            return [
                'week' => $target->format('Y') . ' ' . $target->format('M'),
                'stats' => $this->transactionsDuringMonth(
                    (int)$target->format('Y'),
                    (int)$target->format('n')
                )
            ];
        });
    }

    private function transactionsDuringMonth(int $year, int $monthNumber)
    {
        // Note that since sometimes a product is purchased after midnight
        // we will have to "shift" the time of a transaction when we group
        // the transactions by day so that it gives a more realistic view

        $period = Period::fromMonth($year, $monthNumber);

        $transactions = $this->transactionsInPeriod($period);

        // difference wrt week
        // $datePeriod = '1 WEEK';
        // $format = 'W';

        $weeks = collect($period->getDatePeriod('1 WEEK'))->mapWithKeys(function ($week) : array {
            return [$week->format('W') => null];
        });

        $days = collect($period->getDatePeriod('1 DAY'))->mapWithKeys(function ($day) : array {
            return [$day->format('l') => null];
        });

        // Should change to transactiosn per week
        $transactionsPerDay =
            $transactions->groupBy(function ($transaction) : string {
                $purchaseDate = new DateTimeImmutable($transaction->tijd);

                // Let transactions between 00:00 and 06:00 count for the previous day
                return $purchaseDate->format('W');
            });


        return $transactionsPerDay->map(
            function ($transactions, $day) : array {
                return [
                    "day" => $day, // this is day?
                    "members" => collect($transactions)->unique('lid_id')->count()
                ];
            }
        )->sortBy(function ($day) {
            return $day["day"];
        })->merge([
            "Total" => [
                "day" => "Total",
                "members" => $transactions->unique('lid_id')->count()
            ]
        ]);
    }

    private function transactionsDuringWeek(int $year, int $weekNumber) : Collection
    {
        // Note that since sometimes a product is purchased after midnight
        // we will have to "shift" the time of a transaction when we group
        // the transactions by day so that it gives a more realistic view

        $period = Period::fromIsoWeek($year, $weekNumber);

        $transactions = $this->transactionsInPeriod($period);

        $days = collect($period->getDatePeriod('1 DAY'))->mapWithKeys(function ($day) : array {
            return [$day->format('l') => null];
        });

        $transactionsPerDay = $days->merge(
            $transactions->groupBy(function ($transaction) : string {
                $purchaseDate = new DateTimeImmutable($transaction->tijd);

                // Let transactions between 00:00 and 06:00 count for the previous day
                return $purchaseDate->sub(new DateInterval('PT6H'))->format('l');
            })
        );

        return $transactionsPerDay->map(
            function ($transactions, $day) : array {
                return [
                    "day" => $day,
                    "members" => collect($transactions)->unique('lid_id')->count()
                ];
            }
        )->sortBy(function ($day) : int {
            $dayToNumber = [
                "Monday" => 0,
                "Tuesday" => 1,
                "Wednesday" => 2,
                "Thursday" => 3,
                "Friday" => 4,
                "Saturday" => 5,
                "Sunday" => 6
            ];

            return $dayToNumber[$day["day"]];
        })->merge([
            "Total" => [
                "day" => "Total",
                "members" => $transactions->unique('lid_id')->count()
            ]
        ]);
    }

    private function transactionsInPeriod(Period $period)
    {
        $fromDate = $period->getStartDate();
        $tillDate = $period->getEndDate();

        return DB::connection('francken-legacy')->table('transacties')
            ->join('producten', 'transacties.product_id', '=', 'producten.id')
            ->select([
                'tijd',
                'lid_id',
                'producten.categorie',
                'aantal'
            ])
            ->whereBetween('tijd', [$fromDate, $tillDate])
            ->get();
    }
}
