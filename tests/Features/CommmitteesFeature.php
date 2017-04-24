<?php

declare(strict_types=1);

namespace Francken\Features;

class CommitteesFeature extends TestCase
{
    /** @test */
    function committees_are_listed()
    {
        $this->visit('/association/committees')
            ->see('Committees')
            ->see('Bincie');


        $this->assertResponseOk();
    }

    /** @test */
    function more_info_about_a_committee_can_be_shown()
    {
        $this->visit('/association/committees')
            ->click('Bincie')
            ->see('Committee members');
    }

}
