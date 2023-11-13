<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use DateInterval;
use DateTimeImmutable;
use Francken\Association\Boards\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Webmozart\Assert\Assert;


final class CommitteesStatisticsController
{
    public function index(Request $request) : array
    {
        // By default use the period between today and 6 months ago
        $endDate = DateTimeImmutable::createFromFormat(
            '!Y-m-d',
            $request->get('endDate', ((new DateTimeImmutable()))->format('Y-m-d'))
        )->add(new DateInterval('P1D'));
        Assert::isInstanceOf($endDate, DateTimeImmutable::class);

        $startDate = DateTimeImmutable::createFromFormat(
            '!Y-m-d',
            $request->get('startDate', $endDate->sub(new DateInterval('P6M'))->format('Y-m-d'))
        );
        Assert::isInstanceOf($startDate, DateTimeImmutable::class);

        $statsPerMember = DB::connection('francken-legacy')
                        ->table('transacties')
                        ->orderBy('tijd', 'desc')
                        ->join('producten', 'transacties.product_id', '=', 'producten.id')
                        ->select([DB::raw('sum(aantal) as amount'), 'lid_id', 'categorie',])
                        ->groupBy('lid_id', 'categorie')
                        ->when($startDate, fn ($builder) => $builder->where('tijd', '>=', $startDate))
                        ->when($endDate, fn ($builder) => $builder->where('tijd', '<=', $endDate))
                        ->get();

        // Possibly replace with a query that looks at CommitteeMembers in the given time range?
        $board = Board::latest()->first();
        $committees = $board->committees;
        $committees->load('members');

        $statsPerCommittee = collect();
        $statsPerCommittee = $committees->mapWithKeys(
            fn ($committee) => [$committee->id => collect(['Bier' => 0, 'Fris' => 0, 'Eten' => 0])]
        );

        $statsPerMember->each(function ($stat) use ($committees, $statsPerCommittee) {
            // Add up the member's statistics for each committe they are in
            $committees->each(function ($committee) use ($statsPerCommittee, $stat) {
                $members = $committee->members->pluck('member_id');
                $memberIsPartOfCommittee = $members->contains($stat->lid_id);

                if ($memberIsPartOfCommittee) {
                    $statsPerCommittee[$committee->id][$stat->categorie] += (int)$stat->amount;
                }
            });
        });

        return [
            'statistics' => $statsPerCommittee->map(function ($stats, $committeeId) {
                $committeeName = '';

                return [
                    'committee' => ['id' => $committeeId, 'name' => $committeeName],
                    'beer' => $stats['Bier'],
                    'food' => $stats['Eten'],
                    'soda' => $stats['Fris'],
                ];
            })->values(),
        ];
    }
}
