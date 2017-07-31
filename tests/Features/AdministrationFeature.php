<?php

declare(strict_types=1);

namespace Francken\Features;

use Auth;
use DB;
use Francken\Domain\Members\Registration\Events\RegistrationRequestSubmitted;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * The following are test that check that basic features of the admin page are working
 */
class AdministrationFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;

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

        $this->visit('/admin/committee/create')
            ->type('S[ck]rip(t|t?c)ie', 'name')
            ->type('Digital anarchy', 'summary')
            ->press('Create!');

        // The name should now be listed
        $this->seePageIs('/admin/committee')
            ->see('S[ck]rip(t|t?c)ie')
            ->see('Digital anarchy');

        $this->seeInDatabase('committees_list', [
            'name' => 'S[ck]rip(t|t?c)ie', 'summary' => 'Digital anarchy'
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

    /** @test */
    function blog_and_news_posts()
    {
        $this->visit('/admin/post/create')
            ->type('My title', 'title')
            ->type('My content', 'content')
            ->press('Create!');

        $this->seePageIs('/admin/post')
            ->see('My title')
            ->see('My content');
    }

}
