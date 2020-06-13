<?php

declare(strict_types=1);

namespace Francken\Features\Admin;

use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationRequestsFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;

    /** @test */
    public function listing_all_open_registration_requests() : void
    {
        // TODO
        // Registration::submit();
        $this->markTestIncomplete('This test needs to construct a registration');

        $this->visit('/admin/association/registration-requests')
            ->see('Mark Redeman');
    }

    /** @test */
    public function listing_details_of_a_registration_request() : void
    {
        $this->markTestIncomplete('This test needs to construct a registration');
        $this->visit('admin/association/registration-requests/fffbfb4c-378b-4c76-a0e6-629f3e4e1e9a')
            ->see('Mark Redeman');
    }
}
