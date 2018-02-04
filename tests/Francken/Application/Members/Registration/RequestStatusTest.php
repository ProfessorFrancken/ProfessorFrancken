<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Members\Registration;

use DateTimeImmutable;
use Francken\Application\Members\Registration\RequestStatus;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use PHPUnit\Framework\TestCase as TestCase;
use Francken\Tests\Application\ReadModelTestCase;

class RequestStatusTest extends ReadModelTestCase
{
    /** @test */
    function a_status_is_incomplete_if_information_is_missing()
    {
        $id = RegistrationRequestId::generate();
        $status = new RequestStatus(
            $id,
            'Mark Redeman',
            true, true, true, false,
            new DateTimeImmutable
        );

        $this->assertEquals($id, $status->id());
        $this->assertEquals('Mark Redeman', $status->requestee());
        $this->assertTrue($status->hasPersonalInfo());
        $this->assertTrue($status->hasContactInfo());
        $this->assertTrue($status->hasStudyInfo());
        $this->assertFalse($status->hasPaymentInfo());
        $this->assertFalse($status->complete());
    }

    /** @test */
    function the_status_can_be_complete()
    {
        $id = RegistrationRequestId::generate();
        $status = new RequestStatus(
            $id,
            'Mark Redeman',
            true, true, true, true,
            new DateTimeImmutable
        );

        $this->assertTrue($status->complete());
    }

    protected function createInstance()
    {
        return new RequestStatus(
            RegistrationRequestId::generate(),
            'Mark Redeman',
            true, true, true, false,
            new DateTimeImmutable
        );
    }
}
