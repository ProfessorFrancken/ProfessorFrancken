<?php

declare(strict_types=1);

namespace Francken\Features\Admin;

use Francken\Association\Boards\BoardMember;
use Francken\Association\Boards\BoardMemberStatus;
use Francken\Association\Members\Address;
use Francken\Association\Members\Birthdate;
use Francken\Association\Members\ContactDetails;
use Francken\Association\Members\Email;
use Francken\Association\Members\Fullname;
use Francken\Association\Members\Gender;
use Francken\Association\Members\Http\Controllers\Admin\RegistrationRequestsController;
use Francken\Association\Members\PaymentDetails;
use Francken\Association\Members\PersonalDetails;
use Francken\Association\Members\Registration\Registration;
use Francken\Association\Members\StudyDetails;
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
        $registration = $this->submitRegistration();
        $this->visit(action([RegistrationRequestsController::class, 'index']))
            ->see('Mark Redeman')
            ->see('Inspect')
            ->click('Inspect')
             ->seePageIs(action(
                 [RegistrationRequestsController::class, 'show'],
                 ['registration' => $registration->id]
             ));
    }

    /** @test */
    public function listing_details_of_a_registration_request() : void
    {
        $registration = $this->submitRegistration();
        $this->visit(action(
            [RegistrationRequestsController::class, 'show'],
            ['registration' => $registration->id]
        ))
            ->see('Mark Redeman')
            ->see('Approve');
    }

    /** @test */
    public function editing_a_request() : void
    {
        $registration = $this->submitRegistration();
        $this->visit(action(
            [RegistrationRequestsController::class, 'show'],
            ['registration' => $registration->id]
        ))
            ->see('Mark Redeman')
            ->click('Edit')
             ->seePageIs(action(
                 [RegistrationRequestsController::class, 'edit'],
                 ['registration' => $registration->id]
             ));
        // TODO
    }

    /** @test */
    public function signing_a_registration_by_a_board_member() : void
    {
        $registration = $this->submitRegistration();
        $account = \Francken\Auth\Account::first();
        $boardMember = BoardMember::create([
            'board_id' => 0,
            'member_id' => $account->member_id,
            'name' => 'Mark',
            'title' => 'Mark',

            'board_member_status' => BoardMemberStatus::BOARD_MEMBER,
            'installed_at' => new \DateTimeImmutable(),
        ]);

        $this->visit(action(
            [RegistrationRequestsController::class, 'show'],
            ['registration' => $registration->id]
        ))
            ->see('Mark Redeman')
            ->see('Sign registration form')
            ->submitForm('Sign registration form')
            ->see('Signed');
    }


    // TEST approving, deleting admin stuff
    //

    /** @test */
    public function approving_a_registration_by_a_board_member() : void
    {
        $registration = $this->submitRegistration();
        $account = \Francken\Auth\Account::first();
        $boardMember = BoardMember::create([
            'board_id' => 0,
            'member_id' => $account->member_id,
            'name' => 'Mark',
            'title' => 'Mark',

            'board_member_status' => BoardMemberStatus::BOARD_MEMBER,
            'installed_at' => new \DateTimeImmutable(),
        ]);

        $this->visit(action(
            [RegistrationRequestsController::class, 'show'],
            ['registration' => $registration->id]
        ))
            ->see('Mark Redeman')
            ->see('Approve')
            ->submitForm('Approve')
            ->see('Approved');
    }

    /** @test */
    public function printing_a_registration_form() : void
    {
        $registration = $this->submitRegistration();

        $this->visit(action(
            [RegistrationRequestsController::class, 'print'],
            ['registration' => $registration->id]
        ))
            ->see('Mark Redeman')
            ->see('Member ID')
            ->see($registration->fullname->firstname())
            ->see($registration->fullname->surname());
    }

    /** @test */
    public function approving_a_registration_is_not_allowed() : void
    {
        $registration = $this->submitRegistration();

        $this->expectException(\Laravel\BrowserKitTesting\HttpException::class);
        $this->visit(action(
            [RegistrationRequestsController::class, 'show'],
            ['registration' => $registration->id]
        ))
            ->see('Mark Redeman')
            ->see('Approve')
             ->submitForm('Approve');
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
