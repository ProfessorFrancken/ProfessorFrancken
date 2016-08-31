<?php

declare(strict_types=1);

namespace Francken\Features;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Francken\Domain\Members\Registration\Events\RegistrationRequestSubmitted;

class MemberAdministrationFeature extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_member_can_be_added()
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
}
