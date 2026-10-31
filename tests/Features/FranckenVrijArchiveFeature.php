<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Association\FranckenVrij\Edition;
use Francken\Association\FranckenVrij\EditionId;
use Francken\Association\FranckenVrij\Http\FranckenVrijController;
use Francken\Association\FranckenVrij\Http\FranckenVrijPdfController;
use Francken\Auth\Account;
use Francken\Shared\Url;
use Illuminate\Support\Facades\Storage;

class FranckenVrijArchiveFeature extends TestCase
{
    /** @test */
    public function guests_are_asked_to_login_to_view_the_archive() : void
    {
        $this->publishAFranckenVrij();

        $this->visit(action([FranckenVrijController::class, 'index']))
            ->see('Login to view the Francken Vrij')
            ->dontSee('Francken Vrij 20.1');
    }

    /** @test */
    public function guests_return_to_the_archive_after_logging_in() : void
    {
        $this->visit(action([FranckenVrijController::class, 'index']));

        Account::create([
            'member_id' => 1403,
            'email' => 'member@professorfrancken.nl',
            'password' => bcrypt('secret'),
        ]);

        $this->type('member@professorfrancken.nl', 'email')
            ->type('secret', 'password')
            ->press('Login')
            ->seePageIs(action([FranckenVrijController::class, 'index']))
            ->dontSee('Login to view the Francken Vrij');
    }

    /** @test */
    public function visiting_the_archive_does_not_change_where_other_logins_redirect_to() : void
    {
        $this->visit(action([FranckenVrijController::class, 'index']));

        Account::create([
            'member_id' => 1403,
            'email' => 'member@professorfrancken.nl',
            'password' => bcrypt('secret'),
        ]);

        $this->post(route('login'), [
            'email' => 'member@professorfrancken.nl',
            'password' => 'secret',
        ])->assertRedirectedTo('/profile');
    }

    /** @test */
    public function logging_in_can_not_redirect_to_other_websites() : void
    {
        Account::create([
            'member_id' => 1403,
            'email' => 'member@professorfrancken.nl',
            'password' => bcrypt('secret'),
        ]);

        $this->post(route('login'), [
            'email' => 'member@professorfrancken.nl',
            'password' => 'secret',
            'redirect_to' => '//evil.example.com',
        ])->assertRedirectedTo('/profile');
    }

    /** @test */
    public function members_can_view_the_archive() : void
    {
        $this->publishAFranckenVrij();
        $this->loginAsMember();

        $this->visit(action([FranckenVrijController::class, 'index']))
            ->dontSee('Login to view the Francken Vrij')
            ->see('Francken Vrij 20.1');
    }

    /** @test */
    public function guests_can_not_download_a_francken_vrij() : void
    {
        $edition = $this->publishAFranckenVrij();

        $this->get(action([FranckenVrijPdfController::class, 'show'], ['edition' => $edition]))
            ->assertRedirectedTo(route('login'));
    }

    /** @test */
    public function members_can_download_a_francken_vrij() : void
    {
        Storage::fake('francken-vrij');
        Storage::disk('francken-vrij')->put('20.1.pdf', 'pdf contents');
        $edition = $this->publishAFranckenVrij();
        $this->loginAsMember();

        $this->get(action([FranckenVrijPdfController::class, 'show'], ['edition' => $edition]))
            ->seeStatusCode(200);
    }

    /** @test */
    public function downloading_a_missing_francken_vrij_shows_a_not_found_page() : void
    {
        Storage::fake('francken-vrij');
        $edition = $this->publishAFranckenVrij();
        $this->loginAsMember();

        $this->get(action([FranckenVrijPdfController::class, 'show'], ['edition' => $edition]))
            ->seeStatusCode(404);
    }

    /** @test */
    public function guests_are_asked_to_login_to_read_the_francken_vrij_from_the_homepage() : void
    {
        $this->publishAFranckenVrij();

        $this->visit('/')
            ->see('Login to read the Francken Vrij')
            ->dontSee('Download latest edition')
            ->click('Login to read the Francken Vrij')
            ->seePageIs(action([FranckenVrijController::class, 'index']))
            ->see('Login to view the Francken Vrij');
    }

    /** @test */
    public function members_can_download_the_latest_francken_vrij_from_the_homepage() : void
    {
        $edition = $this->publishAFranckenVrij();
        $this->loginAsMember();

        $this->visit('/')
            ->dontSee('Login to read the Francken Vrij')
            ->see('Download latest edition')
            ->seeLink('Download latest edition', action([FranckenVrijPdfController::class, 'show'], ['edition' => $edition]))
            ->seeLink('Go to the archive', '/association/francken-vrij');
    }

    private function loginAsMember() : void
    {
        $account = Account::create([
            'member_id' => 1403,
            'email' => 'member@professorfrancken.nl',
            'password' => bcrypt('secret'),
        ]);

        $this->actingAs($account);
    }

    private function publishAFranckenVrij() : Edition
    {
        return Edition::publish(
            EditionId::generate(),
            "Francken Vrij 20.1",
            20,
            1,
            new Url("http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.1.jpg"),
            new Url("http://www.professorfrancken.nl/franckenvrij/20.1.pdf")
        );
    }
}
