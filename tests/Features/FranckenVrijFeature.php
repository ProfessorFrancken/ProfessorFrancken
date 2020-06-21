<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Application\FranckenVrij\Edition;
use Francken\Application\FranckenVrij\FranckenVrijRepository;
use Francken\Association\FranckenVrij\EditionId;
use Francken\Domain\Url;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FranckenVrijFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;

    /** @test */
    public function a_list_of_all_francken_vrijs_are_displayed() : void
    {
        $franckenVrij = $this->app->make(FranckenVrijRepository::class);
        $franckenVrij->save(
            Edition::publish(
                EditionId::generate(),
                "Francken Vrij 20.1",
                20,
                1,
                new Url("http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.1.jpg"),
                new Url("http://www.professorfrancken.nl/franckenvrij/20.1.pdf")
            )
        );

        $this->visit('/association/francken-vrij')
            ->see("Francken Vrij 20.1");
    }

    /** @test */
    public function publishing_a_new_francken_vrij() : void
    {
        $this->visit('/admin/association/francken-vrij')
            ->type('Clinical', 'title')
            ->type(20, 'volume')
            ->type(1, 'edition')
            ->attach(__DIR__ . '/stubs/20-1.pdf', 'pdf')
            ->press('Publish');

        $this->seePageIs('/admin/association/francken-vrij')
            ->see('Clinical');
    }

    /** @test */
    public function changing_a_published_francken_vrij() : void
    {
        $franckenVrij = $this->app->make(FranckenVrijRepository::class);
        $id = EditionId::generate();
        $franckenVrij->save(
            Edition::publish(
                $id,
                "Francken Vrij 20.1",
                20,
                1,
                new Url("http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.1.jpg"),
                new Url("http://www.professorfrancken.nl/franckenvrij/20.1.pdf")
            )
        );

        $this->visit("/admin/association/francken-vrij/{$id}")
            ->type('Clinical', 'title')
            ->type(20, 'volume')
            ->type(1, 'edition')
            ->press('Update');

        $this->see('Clinical');
    }

    /** @test */
    public function changing_a_published_francken_vrij_pdf_file() : void
    {
        $franckenVrij = $this->app->make(FranckenVrijRepository::class);
        $id = EditionId::generate();
        $franckenVrij->save(
            Edition::publish(
                $id,
                "Francken Vrij 20.1",
                20,
                1,
                new Url("http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.1.jpg"),
                new Url("http://www.professorfrancken.nl/franckenvrij/20.1.pdf")
            )
        );

        $this->visit("/admin/association/francken-vrij/{$id}")
            ->type('Clinical', 'title')
            ->type(20, 'volume')
            ->type(1, 'edition')
            ->attach(__DIR__ . '/stubs/20-1.pdf', 'pdf')
            ->press('Update');

        $this->see('Clinical');
    }

    /** @test */
    public function removing_a_published_francken_vrij() : void
    {
        $franckenVrij = $this->app->make(FranckenVrijRepository::class);
        $id = EditionId::generate();
        $franckenVrij->save(
            Edition::publish(
                $id,
                "Francken Vrij 20.1",
                20,
                1,
                new Url("http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.1.jpg"),
                new Url("http://www.professorfrancken.nl/franckenvrij/20.1.pdf")
            )
        );

        $this->visit("/admin/association/francken-vrij/{$id}")
            ->press('Archive');

        $this->dontSee('Clinical');
    }
}
