<?php

declare(strict_types=1);

namespace Francken\Tests\Association\Borrelcie\EventHandlers;

use DateTimeImmutable;
use Francken\Association\Boards\Board;
use Francken\Association\Boards\BoardMember;
use Francken\Association\Borrelcie\Anytimer;
use Francken\Association\Borrelcie\BorrelcieAccount;
use Francken\Association\Borrelcie\EventHandlers\HandOutAnytimers;
use Francken\Association\Members\Registration\Events\MemberWasRegistered;
use Francken\Association\Members\Registration\Registration;
use Francken\Features\TestCase;

class HandOutAnytimersTest extends TestCase
{
    private BorrelcieAccount $mark;

    protected function setUp() : void
    {
        parent::setUp();

        $this->mark = factory(BorrelcieAccount::class)->create(['member_id' => 1403]);

        $board = factory(Board::class)->create(['installed_at' => '2020-01-01']);
        $boardMembers = factory(BoardMember::class, 5)->create(['board_id' => $board->id]);
        $boardMembers->each(
            fn (BoardMember $member) => factory(BorrelcieAccount::class)->create(['member_id' => $member->member_id])
        );
    }

    /** @test */
    public function it_hands_out_anytimers_to_the_board_for_the_33rd_online_registration() : void
    {
        factory(Registration::class, 32)->create([
            'registration_accepted_at' => new DateTimeImmutable('2020-01-01')
        ]);

        $registration = factory(Registration::class)->create([
            'registration_accepted_at' => new DateTimeImmutable('2020-01-01')
        ]);
        $event = new MemberWasRegistered($registration);
        $handOutAnytimers = new HandOutAnytimers();
        $handOutAnytimers->handle($event);

        $anytimers = Anytimer::where('drinker_id', $this->mark->id)->get();
        $this->assertCount(5, $anytimers);
    }

    /** @test */
    public function by_default_it_doesnt_hand_out_anytimers() : void
    {
        factory(Registration::class, 31)->create([
            'registration_accepted_at' => new DateTimeImmutable('2020-01-01')
        ]);

        $registration = factory(Registration::class)->create([
            'registration_accepted_at' => new DateTimeImmutable('2020-01-01')
        ]);
        $event = new MemberWasRegistered($registration);
        $handOutAnytimers = new HandOutAnytimers();
        $handOutAnytimers->handle($event);

        $anytimers = Anytimer::where('drinker_id', $this->mark->id)->get();
        $this->assertCount(0, $anytimers);
    }
}
