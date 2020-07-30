<?php

declare(strict_types=1);

namespace Francken\Tests\Association\Committees\Exports;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\CommitteeMember;
use Francken\Association\Committees\Exports\ActiveMembersExport;
use Francken\Association\LegacyMember;
use PHPUnit\Framework\TestCase;

class ActiveMembersExportTest extends TestCase
{
    /** @test */
    public function it_maps_members_names() : void
    {
        $export = new ActiveMembersExport(new Board());
        $member = new LegacyMember(['voornaam' => 'Mark']);
        $committeeMember = new CommitteeMember(['member_id' => 123]);
        $committeeMember->member = $member;

        $mapped = $export->map($committeeMember);
        $this->assertEquals(123, $mapped['member_id']);
        $this->assertEquals('Mark', $mapped['member']);
    }

    /** @test */
    public function it_has_a_heading_and_title() : void
    {
        $export = new ActiveMembersExport(new Board());
        $this->assertEquals('Active members', $export->title());
        $this->assertEquals([
            'Member id',
            'Member',
        ], $export->headings());
    }
}
