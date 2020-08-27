<?php

declare(strict_types=1);

namespace Francken\Tests\Association\Borrelcie;

use Francken\Association\Borrelcie\Anytimer;
use Francken\Association\Borrelcie\BorrelcieAccount;
use Francken\Features\TestCase;

class AnytimerTest extends TestCase
{
    /** @test */
    public function it_computes_the_active_claimed_anytimers_of_a_member() : void
    {
        $borrelcieAccount = factory(BorrelcieAccount::class)->create();
        $otherAccount = factory(BorrelcieAccount::class)->create();

        $anytimers = factory(Anytimer::class, 20)->create([
            'owner_id' => $borrelcieAccount->id,
            'drinker_id' => $otherAccount->id,
        ]);

        $expected = $anytimers->filter(
            fn (Anytimer $anytimer) => $anytimer->context === 'used' || $anytimer->accepted
        )->pluck('amount')->sum();

        $activeClaimedAnytimers = Anytimer::activeClaimedAnytimers($borrelcieAccount)->get();

        $this->assertEquals(
            [
                [
                    'owner_id' => $borrelcieAccount->id,
                    'drinker_id' => $otherAccount->id,
                    'count_active' => $expected,
                ]
            ],
            $activeClaimedAnytimers->toArray()
        );
    }

    /** @test */
    public function it_computes_the_active_given_anytimers_of_a_member() : void
    {
        $borrelcieAccount = factory(BorrelcieAccount::class)->create();
        $otherAccount = factory(BorrelcieAccount::class)->create();

        $anytimers = factory(Anytimer::class, 20)->create([
            'drinker_id' => $borrelcieAccount->id,
            'owner_id' => $otherAccount->id,
        ]);

        $expected = $anytimers->filter(
            fn (Anytimer $anytimer) => $anytimer->context === 'used' || $anytimer->accepted
        )->pluck('amount')->sum();

        $activeGivenAnytimers = Anytimer::activeGivenAnytimers($borrelcieAccount)->get();

        $this->assertEquals(
            [
                [
                    'owner_id' => $otherAccount->id,
                    'drinker_id' => $borrelcieAccount->id,
                    'count_active' => $expected,
                ]
            ],
            $activeGivenAnytimers->toArray()
        );
    }
}
