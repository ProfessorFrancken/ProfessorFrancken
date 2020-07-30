<?php

declare(strict_types=1);

namespace Francken\Tests\Association\Committees\Exports;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
use Francken\Association\Committees\Exports\CommitteeMembersExport;
use Francken\Association\LegacyMember;
use PHPUnit\Framework\TestCase;

class CommitteeMembersExportTest extends TestCase
{
    /** @test */
    public function it_maps_members_names() : void
    {
        $export = new CommitteeMembersExport(new Board());
        $member = new LegacyMember(['voornaam' => 'Mark']);
        $committee = new Committee(['name' => 'S[ck]rip(t|t?c)ie']);
        $committeeMember = new CommitteeMember([
            'member_id' => 123,
            'committee_id' => 321,
        ]);
        $committeeMember->member = $member;
        $committeeMember->committee = $committee;


        $mapped = $export->map($committeeMember);
        $this->assertEquals([
            'member_id' => 123,
            'committee_id' => 321,
            'member' => 'Mark',
            'function' => null,
            'committee' => 'S[ck]rip(t|t?c)ie',
            'installed_at' => null,
            'decharged_at' => null,
        ], $mapped);
    }

    /** @test */
    public function it_has_a_heading_and_title() : void
    {
        $export = new CommitteeMembersExport(new Board());
        $this->assertEquals('Committee members', $export->title());
        $this->assertEquals([
            'Member id',
            'Committee id',
            'Member',
            'Fucntion',
            'Committee name',
            'Installed at',
            'Decharged at',
        ], $export->headings());
    }
}
