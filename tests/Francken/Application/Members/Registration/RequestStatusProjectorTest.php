<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Members\Registration;

use Broadway\Domain\DateTime;
use DateTimeImmutable;
use Francken\Application\Members\Registration\RequestStatus;
use Francken\Application\Members\Registration\RequestStatusProjector;
use Francken\Application\Members\Registration\RequestStatusRepository;
use Francken\Application\Projector;
use Francken\Domain\Members\Address;
use Francken\Domain\Members\ContactInfo;
use Francken\Domain\Members\Email;
use Francken\Domain\Members\FullName;
use Francken\Domain\Members\Gender;
use Francken\Domain\Members\PaymentInfo;
use Francken\Domain\Members\Registration\Events\RegistrationRequestSubmitted;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Francken\Domain\Members\StudyDetails;
use Francken\Infrastructure\Repositories\InMemoryRepository;
use Francken\Tests\Application\ProjectorScenarioTestCase as TestCase;

class RequestStatusProjectorTest extends TestCase
{
    /** @test */
    function it_keeps_track_of_opened_registration_requests()
    {
        $id = RegistrationRequestId::generate();
        $this->scenario->when(
            new RegistrationRequestSubmitted(
                $id,
                new FullName('Mark', '', 'Redeman'),
                Gender::fromString('male'),
                new DateTimeImmutable('1993-04-26'),
                ContactInfo::describe(
                    new Email('markredeman@gmail.com'),
                    new Address(
                        'Groningen',
                        '9742GS',
                        'Plutolaan 11'
                    )
                ),
                new StudyDetails(
                    's2218356',
                    'Msc Applied Mathematics',
                    new DateTimeImmutable('2011-09-01')
                )
            ),
            DateTime::fromString('2016-07-18 00:00:00')
        )->then([
            new RequestStatus(
                $id,
                'Mark Redeman',
                false, false, false, false,
                new DateTimeImmutable('2016-07-18 00:00:00')
            )
        ]);
    }


    protected function createProjector(InMemoryRepository $repository) : Projector
    {
        $this->requests = new InMemoryRepository;

        return new RequestStatusProjector(
            new RequestStatusRepository(
                $repository
            )
        );
    }

}
