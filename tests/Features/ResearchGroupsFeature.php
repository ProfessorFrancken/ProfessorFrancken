<?php

declare(strict_types=1);

namespace Francken\Features;

class ResearchGroupsFeature extends TestCase
{
    /** @test */
    public function research_groups_are_displayed_with_additional_information() : void
    {
        $this->visit('/study/research-groups')
            ->click('Materials Science')
            ->seePageIs('/study/research-groups/materials-science')
            ->see('De Hosson');

        $this->assertResponseOk();
    }
}
