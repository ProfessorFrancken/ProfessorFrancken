<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Commands;

use DB;
use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
use Francken\Association\Committees\FileUploader;
use Francken\Association\Committees\HardcodedCommittee;
use Francken\Association\Committees\HardcodedCommitteesRepository;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
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
    public function handle(HardcodedCommitteesRepository $hardcodedCommittees, FileUploader $uploader) : void
    {
        Schema::disableForeignKeyConstraints();
        CommitteeMember::query()->delete();
        Committee::query()->delete();
        Schema::enableForeignKeyConstraints();
        $hardcodedCommittees = app(\Francken\Association\Committees\HardcodedCommitteesRepository::class);
        $legacyCommitteeMembers = DB::connection('francken-legacy')->table('commissie_lid')->get();

        $legacyCommitteeMembers->groupBy(['commissie_id', 'jaar'])->map(function ($committeeMembersByYear, $committeeId) use ($hardcodedCommittees, $uploader) {
            $legacyCommittee = DB::connection('francken-legacy')->table('commissies')->find($committeeId);

            if ($legacyCommittee->naam === 'bestuur' || $legacyCommittee->naam === 'Bestuur') {
                return;
            }

            $this->info("Importing {$legacyCommittee->naam}");
            $perviousCommitteeId = null;
            return $committeeMembersByYear->map(function ($members, $year) use (&$perviousCommitteeId, $legacyCommittee, $hardcodedCommittees, $uploader) : Committee {
                $board = Board::whereYear('installed_at', $year)->first();

                $hardcodedCommittee = collect($hardcodedCommittees->list())->first(
                    function ($committee) use ($legacyCommittee) {
                        return $legacyCommittee->id === $committee->id() ?? null;
                    }
                );
                $fallbackPage = optional($hardcodedCommittee)->page();


                $committee = Committee::create([
                    'board_id' => $board->id,
                    'parent_committee_id' => $perviousCommitteeId,

                    'name' => $legacyCommittee->naam,
                    'slug' => str_slug($legacyCommittee->naam),
                    'email' => $legacyCommittee->emailadres,
                    'is_public' => $fallbackPage !== null,
                    'fallback_page' => $fallbackPage ?? 'association.committees.fallback',
                ]);

                $members->each(function ($member) use ($committee, $board) : void {
                    CommitteeMember::create([
                        'committee_id' => $committee->id,
                        'member_id' => $member->lid_id,
                        'function' => $member->functie,
                        'installed_at' => $board->installed_at,
                        'decharged_at' => $board->demissioned_at,
                    ]);
                });

                // TODO: uplaod committee logo
                $logo = $this->downloadFile($hardcodedCommittee);

                if ($logo) {
                    $uploader->uploadLogo($logo, $committee);
                }

                // dump($committee->toArray(), $committeeMembers->toArray());

                $perviousCommitteeId = $committee->id;
                return $committee;
            });
        });

        \Storage::deleteDirectory('import-committees');
    }

    private function downloadFile(?HardcodedCommittee $committee) : ?UploadedFile
    {
        if ($committee === null) {
            return null;
        }

        $url = $committee->logo();

        if ($url === null || $url === '') {
            return null;
        }

        try {
            $contents = file_get_contents($url);
            $basename = substr($url, strrpos($url, '/') + 1);
            $name = 'import-committees/' . $basename;
            \Storage::put($name, $contents);
            return new UploadedFile(storage_path('app/' . $name), $basename, null, null, true);
        } catch (\Exception $e) {
            return null;
        }
    }
}
