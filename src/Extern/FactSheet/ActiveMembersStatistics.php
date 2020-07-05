<?php

declare(strict_types=1);

namespace Francken\Extern\FactSheet;

use DateTimeImmutable;
use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
use Francken\Shared\AcademicYear;

final class ActiveMembersStatistics
{
    private DateTimeImmutable $today;

    public function __construct(DateTimeImmutable $today)
    {
        $this->today = $today;
    }

    public function handle() : ActiveMembers
    {
        $year = AcademicYear::fromDate(
            $this->today
        );

        $board = Board::orderBy('installed_at', 'desc')->first();

        // Select all members that are in at least one committee
        $activeMemberIds = $board->committees->flatMap(function (Committee $committee) {
            return $committee->members->map(function (CommitteeMember $member) : int {
                return $member->member_id;
            });
        })->unique();


        $members = \DB::connection('francken-legacy')
                 ->table('leden')
                 ->whereIn('id', $activeMemberIds)
                 ->get();

        return new ActiveMembers($members);
    }
}
