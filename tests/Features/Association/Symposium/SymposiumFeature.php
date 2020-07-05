<?php

declare(strict_types=1);

namespace Francken\Features\Association\Symposium;

use DateTimeImmutable;
use Francken\Association\Symposium\Http\AdminSymposiaController;
use Francken\Association\Symposium\Http\AdminSymposiumParticipantsController;
use Francken\Association\Symposium\Http\ParticipantRegistrationController;
use Francken\Association\Symposium\ParticipantRegisteredForSymposium;
use Francken\Association\Symposium\Symposium;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Francken\Shared\Email;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;

class SymposiumFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;

    /** @test */
    public function it_shows_the_latest_symposia() : void
    {
        Symposium::create([
            'name' => 'In a materialistic world',
            'start_date' => new DateTimeImmutable('05-05-2019 09:00'),
            'end_date' => new DateTimeImmutable('05-05-2019 18:00'),
            'location' => 'EM2',
            'website_url' => 'https://franckensymposium.nl',
            'open_for_registration' => true,
            'promote_on_agenda' => true,
        ]);

        $this->visit(action([AdminSymposiaController::class, 'index']))
            ->see('Symposia')
            ->see('In a materialistic world');

        $this->assertResponseOk();
    }

    /** @test */
    public function it_lets_us_create_a_symposium() : void
    {
        $this->visit(action([AdminSymposiaController::class, 'create']));

        $this->type('In a materialistic world', 'name')
            ->type('EM2', 'location')
            ->type('https://franckensymposium.nl', 'website_url')
            ->type('05-05-2019 09:00', 'start_date')
            ->type('05-05-2019 18:00', 'end_date')
            ->check('open_for_registration')
            ->uncheck('promote_on_agenda')
            ->press('Add symposium');

        $this->seeInDatabase('association_symposia', [
            'name' => 'In a materialistic world',
            'open_for_registration' => true,
            'promote_on_agenda' => false,
        ]);

        $this->assertResponseOk();
    }

    /** @test */
    public function it_lets_us_edit_a_symposium() : void
    {
        $symposium = Symposium::create([
            'name' => 'Power from within',
            'start_date' => new DateTimeImmutable('05-05-2018 09:00'),
            'end_date' => new DateTimeImmutable('05-05-2018 18:00'),
            'location' => 'Van Swinderen Huys',
            'website_url' => 'https://franckensymposium.nl',
            'open_for_registration' => false,
            'promote_on_agenda' => false,
        ]);

        $this->visit(action([AdminSymposiaController::class, 'edit'], $symposium->id));

        $this->type('In a materialistic world', 'name')
            ->type('EM2', 'location')
            ->type('https://franckensymposium.nl', 'website_url')
            ->type('05-05-2019 09:00', 'start_date')
            ->type('05-05-2019 18:00', 'end_date')
            ->check('open_for_registration')
            ->check('promote_on_agenda')
            ->press('Save');

        $this->seeInDatabase('association_symposia', [
            'name' => 'In a materialistic world',
            'start_date' => new DateTimeImmutable('05-05-2019 09:00'),
            'end_date' => new DateTimeImmutable('05-05-2019 18:00'),
            'location' => 'EM2',
            'open_for_registration' => true,
            'promote_on_agenda' => true,
        ]);
    }

    /** @test */
    public function it_registers_participants() : void
    {
        $symposium = Symposium::create([
            'name' => 'In a materialistic world',
            'start_date' => new DateTimeImmutable('05-05-2019 09:00'),
            'end_date' => new DateTimeImmutable('05-05-2019 18:00'),
            'location' => 'EM2',
            'website_url' => 'https://franckensymposium.nl',
            'open_for_registration' => true,
            'promote_on_agenda' => true,
        ]);
        Event::fake();

        $symposium->registerParticipant(
            'Mark',
            'Redeman',
            new Email('markredeman@gmail.com'),
            true,
            true,
            '1234567890',
            true
        );

        $this->seeInDatabase('association_symposium_participants', [
            'firstname' => 'Mark',
            'lastname' => 'Redeman',
            'email' => 'markredeman@gmail.com',
            'symposium_id' => $symposium->id,
        ]);

        Event::assertDispatched(
            ParticipantRegisteredForSymposium::class,
            function ($e) use ($symposium): bool {
                return $e->participant->symposium_id === $symposium->id;
            }
        );
    }

    /** @test */
    public function it_shows_a_list_of_registered_participants() : void
    {
        $symposium = Symposium::create([
            'name' => 'In a materialistic world',
            'start_date' => new DateTimeImmutable('05-05-2019 09:00'),
            'end_date' => new DateTimeImmutable('05-05-2019 18:00'),
            'location' => 'EM2',
            'website_url' => 'https://franckensymposium.nl',
            'open_for_registration' => true,
            'promote_on_agenda' => true,
        ]);

        $symposium->registerParticipant(
            'Mark',
            'Redeman',
            new Email('markredeman@gmail.com'),
            true,
            true,
            '1234567890',
            true
        );

        $this->visit(action([AdminSymposiaController::class, 'show'], $symposium->id))
            ->see('In a materialistic world')
            ->see('Mark Redeman');

        $this->assertResponseOk();
    }

    /** @test */
    public function it_lets_us_manually_add_participants() : void
    {
        $symposium = Symposium::create([
            'name' => 'In a materialistic world',
            'start_date' => new DateTimeImmutable('05-05-2019 09:00'),
            'end_date' => new DateTimeImmutable('05-05-2019 18:00'),
            'location' => 'EM2',
            'website_url' => 'https://franckensymposium.nl',
            'open_for_registration' => true,
            'promote_on_agenda' => true,
        ]);

        $this->visit(action([AdminSymposiumParticipantsController::class, 'create'], $symposium->id))
            ->type('Mark', 'firstname')
            ->type('Redeman', 'lastname')
            ->type('markredeman@gmail.com', 'email')
            ->check('is_francken_member')
            ->check('is_nnv_member')
            ->type('1403', 'member_id')
            ->type('706116', 'nnv_number')
            ->check('pays_with_iban')
            ->press('Add participant')
            ->see('Mark Redeman')
            ->see('Not yet verified');
    }

    /** @test */
    public function it_allows_us_to_register_a_participant_using_an_api() : void
    {
        $symposium = Symposium::create([
            'name' => 'In a materialistic world',
            'start_date' => new DateTimeImmutable('05-05-2019 09:00'),
            'end_date' => new DateTimeImmutable('05-05-2019 18:00'),
            'location' => 'EM2',
            'website_url' => 'https://franckensymposium.nl',
            'open_for_registration' => true,
            'promote_on_agenda' => true,
        ]);

        $response = $this->json(
            'POST',
            action([ParticipantRegistrationController::class, 'store'], $symposium->id),
            [
                'firstname' => 'Mark',
                'lastname' => 'Redeman',
                'email' => 'markredeman@gmail.com',
                'is_francken_member' => true,
                'is_nnv_member' => true,
                'nnv_number' => '706116',
                'payment_method'=> 'debit',
                'iban' => 'NL18ABNA0484869868'
            ]
        )->assertResponseOk();


        $this->seeInDatabase('association_symposium_participants', [
            'firstname' => 'Mark',
            'lastname' => 'Redeman',
            'email' => 'markredeman@gmail.com',
            'symposium_id' => $symposium->id,
        ]);
        $participant = $symposium->participants->where('email', 'markredeman@gmail.com')
            ->first();

        $this->assertEquals(
            'NL18ABNA0484869868',
            decrypt($participant->iban)
        );
    }
}
