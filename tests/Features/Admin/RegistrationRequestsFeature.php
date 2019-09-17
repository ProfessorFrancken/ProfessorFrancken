<?php

declare(strict_types=1);

namespace Francken\Features\Admin;

use Francken\Application\Members\Registration\RequestStatus;
use Francken\Application\Members\Registration\RequestStatusRepository;
use Francken\Domain\Members\Registration\RegistrationRequestId;
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
    public function listing_details_of_a_registration_request() : void
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
