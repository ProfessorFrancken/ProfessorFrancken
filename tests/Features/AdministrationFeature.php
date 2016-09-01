<?php

declare(strict_types=1);

namespace Francken\Features;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Francken\Domain\Members\Registration\Events\RegistrationRequestSubmitted;

/**
 * The following are test that check that basic features of the admin page are working
 */
class AdministrationFeature extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function members_can_be_managed()
    {
        $this->visit('/admin/member')
            ->type('Mark', 'first_name')
            ->type('Redeman', 'last_name')
            ->press('Add member');

        // The name should now be listed
        $this->seePageIs('/admin/member')
            ->see('Mark')
            ->see('Redeman');

        // Implementation detail =)
        $this->seeInDatabase('event_store', [
            'type' => 'Francken.Domain.Members.Events.MemberJoinedFrancken'
        ]);
    }

    /** @test */
    function committees_can_be_managed()
    {
        // Given we have a user  names Mark Redeman
        $this->visit('/admin/member')
            ->type('Mark', 'first_name')
            ->type('Redeman', 'last_name')
            ->press('Add member');

        $this->visit('/admin/committee')
            ->type('S[ck]rip(t|t?c)ie', 'inputName')
            ->type('Digital anarchy', 'inputGoal')
            ->press('Create committee');

        // The name should now be listed
        $this->seePageIs('/admin/committee')
            ->see('S[ck]rip(t|t?c)ie')
            ->see('Digital anarchy');

        $this->seeInDatabase('committees_list', [
            'name' => 'S[ck]rip(t|t?c)ie', 'goal' => 'Digital anarchy'
        ]);

        // Next let's edit the committee
        //
        $this->click('Edit');

        // Search for a member
        $this->type('mark', 'first_name')
            ->press('Search')
            ->press('add-member')
            ->see('Redeman');

        // And we should also be able to remove the member
        $this->press('remove-member')
            ->dontSee('Redeman');
    }
}
