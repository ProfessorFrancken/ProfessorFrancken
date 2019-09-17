<?php

declare(strict_types=1);

namespace Francken\Features;

class CommmitteesFeature extends TestCase
{
    /** @test */
    public function committees_are_listed() : void
    {
        $this->visit('/association/committees')
            ->see('Committees')
            ->see('Borrelcie');


        $this->assertResponseOk();
    }

    /** @test */
    public function more_info_about_a_committee_can_be_shown() : void
    {
        $this->visit('/association/committees')
            ->click('Borrelcie')
            ->see('Committee members');
    }
}
