<?php

declare(strict_types=1);

namespace Francken\Features\Admin;

use Auth;
use DB;
use Francken\Application\Members\Registration\RequestStatus;
use Francken\Application\Members\Registration\RequestStatusRepository;
use Francken\Domain\Members\Registration\Events\RegistrationRequestSubmitted;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Francken\Features\TestCase;
use Francken\Features\LoggedInAsAdmin;

class RegistrationRequestFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;

    /** @test */
    function listing_all_open_registration_requests()
    {
        $requests = $this->app->make(RequestStatusRepository::class);
        $requests->save(
            new RequestStatus(
                new RegistrationRequestId('fffbfb4c-378b-4c76-a0e6-629f3e4e1e9a'),
                'Mark Redeman',
                true,
                true,
                true,
                true,
                \DateTimeImmutable::createFromFormat(
                    \DateTime::ISO8601,
                    '2016-11-18T15:52:01+0000'
                )
            )
        );

        $this->visit('/admin/association/registration-requests')
            ->see('Mark Redeman');
    }

    /** @test */
    function listing_details_of_a_registration_request()
    {
        $requests = $this->app->make(RequestStatusRepository::class);
        $requests->save(
            new RequestStatus(
                new RegistrationRequestId('fffbfb4c-378b-4c76-a0e6-629f3e4e1e9a'),
                'Mark Redeman',
                true,
                true,
                true,
                true,
                \DateTimeImmutable::createFromFormat(
                    \DateTime::ISO8601,
                    '2016-11-18T15:52:01+0000'
                )
            )
        );

        $this->visit('admin/association/registration-requests/fffbfb4c-378b-4c76-a0e6-629f3e4e1e9a')
            ->see('Mark Redeman');
    }
}
