<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Commands;

use DB;
use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
use Francken\Association\Committees\HardcodedCommitteesRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

final class ImportFromLegacyDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:committees-from-legacy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate the old "commissies" table to committees';

    /**
     * Execute the console command.
     */
    public function handle(HardcodedCommitteesRepository $hardcodedCommittees) : void
    {
        Schema::disableForeignKeyConstraints();
        CommitteeMember::query()->delete();
        Committee::query()->delete();
        Schema::enableForeignKeyConstraints();
        $hardcodedCommittees = app(\Francken\Association\Committees\HardcodedCommitteesRepository::class);
        $legacyCommitteeMembers = DB::connection('francken-legacy')->table('commissie_lid')->get();

        $legacyCommitteeMembers->groupBy(['commissie_id', 'jaar'])->map(function ($committeeMembersByYear, $committeeId) use ($hardcodedCommittees) {
            $legacyCommittee = DB::connection('francken-legacy')->table('commissies')->find($committeeId);

            $this->info("Importing {$legacyCommittee->naam}");
            $perviousCommitteeId = null;
            return $committeeMembersByYear->map(function ($members, $year) use (&$perviousCommitteeId, $legacyCommittee, $hardcodedCommittees) : Committee {
                $board = Board::whereYear('installed_at', $year)->first();

                $fallbackPage = collect($hardcodedCommittees->list())->filter(
                    function ($committee) use ($legacyCommittee) {
                        return $legacyCommittee->id === $committee->id() ?? null;
                    }
                )->map(function ($committee) {
                    return $committee->page();
                })->first();

                $committee = Committee::create([
                    'board_id' => $board->id,
                    'parent_committee_id' => $perviousCommitteeId,

                    'name' => $legacyCommittee->naam,
                    'name' => str_slug($legacyCommittee->naam),
                    'email' => $legacyCommittee->emailadres,
                    'is_public' => $fallbackPage !== null,
                    'fallback_page' => $fallbackPage ?? 'association.committees.fallback',
                ]);

                $committeeMembers = $members->map(function ($member) use ($committee, $board) : CommitteeMember {
                    return CommitteeMember::create([
                        'committee_id' => $committee->id,
                        'member_id' => $member->lid_id,
                        'function' => $member->functie,
                        'installed_at' => $board->installed_at,
                        'decharged_at' => $board->demissioned_at,
                    ]);
                });

                // dump($committee->toArray(), $committeeMembers->toArray());

                $perviousCommitteeId = $committee->id;
                return $committee;
            });
        });

        return;
        $this->info("Imported {$committees->count()} committees");
    }
}
