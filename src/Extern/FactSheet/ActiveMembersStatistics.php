<?php

declare(strict_types=1);

namespace Francken\Extern\FactSheet;

use DateTimeImmutable;
use Francken\Shared\AcademicYear;

final class ActiveMembersStatistics
{
    private $today;

    public function __construct(DateTimeImmutable $today)
    {
        $this->today = $today;
    }

    public function handle()
    {
        $year = Francken\Career\AcademicYear::fromDate(
            $this->today
        );

        // Select all members that are in at least one committee
        $members = \DB::connection('francken-legacy')
                 ->table('commissie_lid')
                 ->join('leden', 'leden.id', 'commissie_lid.lid_id')
                 ->where('jaar', $year->start()->format('Y') - 1)
                 ->get()
                 ->unique(function ($member) {
                     return $member->lid_id;
                 });

        return new ActiveMembers($members);
    }
}
