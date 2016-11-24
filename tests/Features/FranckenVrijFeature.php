<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Application\FranckenVrij\Edition;
use Francken\Application\FranckenVrij\FranckenVrijRepository;
use Francken\Domain\FranckenVrij\EditionId;
use Francken\Domain\Url;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FranckenVrijFeature extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_list_of_all_francken_vrijs_are_displayed()
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
            ->see("Volume 20");
    }

    /** @test */
    function publishing_a_new_francken_vrij()
    {
        $this->visit('/admin/francken-vrij')
            ->type('Clinical', 'title')
            ->type(20, 'volume')
            ->type(1, 'edition')
            ->attach(__DIR__ . '/stubs/20-1.pdf', 'pdf')
            ->press('Publish');

        $this->seePageIs('/admin/francken-vrij')
            ->see('Clinical');
    }

    /** @test */
    function changing_a_published_francken_vrij()
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

        $this->visit("/admin/francken-vrij/{$id}")
            ->type('Clinical', 'title')
            ->type(20, 'volume')
            ->type(1, 'edition')
            ->press('Update');

        $this->see('Clinical');
    }

    /** @test */
    function changing_a_published_francken_vrij_pdf_file()
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

        $this->visit("/admin/francken-vrij/{$id}")
            ->type('Clinical', 'title')
            ->type(20, 'volume')
            ->type(1, 'edition')
            ->attach(__DIR__ . '/stubs/20-1.pdf', 'pdf')
            ->press('Update');

        $this->see('Clinical');
    }
}
