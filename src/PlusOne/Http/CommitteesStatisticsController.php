<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use DateInterval;
use DateTimeImmutable;
use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
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
            $request->string('endDate', ((new DateTimeImmutable()))->format('Y-m-d'))->toString()
        );
        Assert::isInstanceOf($endDate, DateTimeImmutable::class);
        // endDate argument is inclusive, we would either need to set the
        // time to 23:59 or add 1 day and set time to 00:00, we do the latter
        $endDate = $endDate->add(new DateInterval('P1D'));

        $startDate = DateTimeImmutable::createFromFormat(
            '!Y-m-d',
            $request->string('startDate', $endDate->sub(new DateInterval('P6M'))->format('Y-m-d'))->toString()
        );
        Assert::isInstanceOf($startDate, DateTimeImmutable::class);

        // Get the total amount of transactions made per member and product category
        // gives ['amount' => int, 'lid_id' => int, 'categorie' => 'Bier' | 'Eten' | 'Fris']
        $statsPerMember = DB::connection('francken-legacy')
            ->table('transacties')
            ->orderBy('tijd', 'desc')
            ->join('producten', 'transacties.product_id', '=', 'producten.id')
            ->select([DB::raw('sum(aantal) as amount'), 'lid_id', 'categorie', ])
            ->groupBy('lid_id', 'categorie')
            ->when($startDate, fn ($builder) => $builder->where('tijd', '>=', $startDate))
            ->when($endDate, fn ($builder) => $builder->where('tijd', '<=', $endDate))
            ->get();

        // For each transactions
        $committeeMembers = CommitteeMember::whereIn(
            'member_id',
            $statsPerMember->pluck('lid_id')->unique()
        )->with(['committee', 'committee.board'])
         ->get()
         ->filter(function ($member) use ($endDate, $startDate) {
             if ( ! $member->committee) {
                 return false;
             }

             /**  @var Board $board */
             $board = $member->committee->board;

             /**  @var \Illuminate\Support\Carbon $installedAt */
             $installedAt = $board->installed_at;

             if ( ! $installedAt->isBefore($endDate)) {
                 return false;
             }

             /**  @var \Illuminate\Support\Carbon|null $demissionedAt */
             $demissionedAt = $board->demissioned_at;

             if ($demissionedAt === null) {
                 return true;
             }

             return ! $demissionedAt->isBefore($startDate);
         });


        $statsPerCommittee = $committeeMembers
                        ->map(fn ($member) => $member->committee)
                        ->unique()
                        ->mapWithKeys(
                            fn (Committee $committee) => [
                                $committee->id => collect([
                                    'name' => $committee->name,
                                    'Bier' => 0,
                                    'Fris' => 0,
                                    'Eten' => 0,
                                ])
                            ]
                        );

        $statsPerMember->each(function ($stat) use ($statsPerCommittee, $committeeMembers) : void {
            $committeesForThisMember = $committeeMembers->filter(function ($cm) use ($stat) {
                return $cm->member_id === $stat->lid_id;
            });

            $committeesForThisMember->each(function ($committeeMember) use ($stat, $statsPerCommittee) : void {
                /**  @var \Illuminate\Support\Collection<string, int> $statsFromCommittee */
                $statsFromCommittee = $statsPerCommittee[(int)$committeeMember->committee_id];
                $statsFromCommittee[(string)$stat->categorie] += (int)$stat->amount;
            });
        });

        return [
            'statistics' => $statsPerCommittee->map(function ($stats, $committeeId) {
                return [
                    'committee' => [
                        'id' => $committeeId,
                        'name' => $stats['name']
                    ],
                    'beer' => $stats['Bier'],
                    'food' => $stats['Eten'],
                    'soda' => $stats['Fris'],
                ];
            })->values(),
        ];
    }
}
