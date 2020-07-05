<?php

declare(strict_types=1);

namespace Francken\Tests\Association\Members\Registration;

use Francken\Tests\LaravelTestCase;
use Francken\Association\Members\Registration\Events\RegistrationWasSubmitted;
use Francken\Association\Members\Registration\Events\RegistrationWasApproved;
use DateTimeImmutable;
use Francken\Association\Boards\BoardMember;
use Francken\Association\Members\Address;
use Francken\Association\Members\Birthdate;
use Francken\Association\Members\ContactDetails;
use Francken\Association\Members\Email;
use Francken\Association\Members\Fullname;
use Francken\Association\Members\Gender;
use Francken\Association\Members\PaymentDetails;
use Francken\Association\Members\PersonalDetails;
use Francken\Association\Members\Registration\Events;
use Francken\Association\Members\Registration\Registration;
use Francken\Association\Members\Registration\RegistrationException;
use Francken\Association\Members\StudyDetails;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;

// use Francken\Association\Members\Study;

class RegistrationTest extends LaravelTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_registration_can_be_submitted() : void
    {
        Event::fake([RegistrationWasSubmitted::class]);

        $registration = $this->submitRegistration();

        $this->assertIsInt($registration->id);
        Event::assertDispatched(RegistrationWasSubmitted::class);
    }

    /** @test */
    public function a_registration_can_be_approved_by_a_board_member() : void
    {
        Event::fake([RegistrationWasApproved::class]);
        $boardMember = new BoardMember();
        $at = new DateTimeImmutable();
        $registration = $this->submitRegistration();
        $registration->approve($boardMember, $at);

        $this->assertEquals($at, $registration->registration_accepted_at);
        Event::assertDispatched(RegistrationWasApproved::class);
    }

    /** @test */
    public function a_registration_cant_be_confirmed_a_second_time() : void
    {
        Event::fake([RegistrationWasApproved::class]);
        $boardMember = new BoardMember();
        $at = new DateTimeImmutable();
        $registration = $this->submitRegistration();
        $registration->approve($boardMember, $at);

        $this->expectException(RegistrationException::class);
        $registration->approve($boardMember, $at);
    }


    /** @test */
    public function a_registration_requests_email_can_be_confirmed() : void
    {
        $registration = $this->submitRegistration();
        $at = new DateTimeImmutable();
        $registration->confirmEmail($at);

        $this->assertEquals($at, $registration->email_verified_at);
    }

    /** @test */
    public function a_registration_can_be_signed() : void
    {
        $at = new DateTimeImmutable();
        $registration = $this->submitRegistration();
        $registration->signRegistrationForm($at);

        $this->assertEquals($at, $registration->registration_form_signed_at);
    }

    private function submitRegistration() : Registration
    {
        return Registration::submit(
            new PersonalDetails(
                Fullname::fromFirstnameAndSurname('Mark', 'Redeman'),
                'M. S.',
                Gender::MALE(),
                Birthdate::fromString('1993-04-26'),
                'Netherlands',
                true
            ),
            new ContactDetails(
                new Email('markredeman@gmail.com'),
                new Address(
                    'Groningen',
                    '9742 GS',
                    'Nijenborgh 9',
                    'Netherlands'
                ),
                null
            ),
            new StudyDetails('s1111111'),
            new PaymentDetails('NL91 ABNA 0417 1643 00', null, true),
            true,
            ''
        );
    }
}
