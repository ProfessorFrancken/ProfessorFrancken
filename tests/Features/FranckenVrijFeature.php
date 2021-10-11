<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Association\FranckenVrij\Edition;
use Francken\Association\FranckenVrij\EditionId;
use Francken\Association\FranckenVrij\Http\AdminFranckenVrijController;
use Francken\Shared\Url;

class FranckenVrijFeature extends TestCase
{
    use LoggedInAsAdmin;

    /** @test */
    public function a_list_of_all_francken_vrijs_are_displayed() : void
    {
        Edition::publish(
            EditionId::generate(),
            "Francken Vrij 20.1",
            20,
            1,
            new Url("http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.1.jpg"),
            new Url("http://www.professorfrancken.nl/franckenvrij/20.1.pdf")
        );

        $this->visit(action([AdminFranckenVrijController::class, 'index']))
            ->see("Francken Vrij 20.1");
    }

    /** @test */
    public function publishing_a_new_francken_vrij() : void
    {
        $this->markTestSkipped('Github actions have issues with imagick');
        $this->visit(action([AdminFranckenVrijController::class, 'index']))
            ->type('Clinical', 'title')
            ->type(20, 'volume')
            ->type(1, 'edition')
            ->attach(__DIR__ . '/stubs/20-1.pdf', 'pdf')
            ->press('Publish');

        $this->seePageIs(action([AdminFranckenVrijController::class, 'index']))
            ->see('Clinical');
    }

    /** @test */
    public function changing_a_published_francken_vrij() : void
    {
        $this->markTestSkipped('Github actions have issues with imagick');
        $edition = Edition::publish(
            EditionId::generate(),
            "Francken Vrij 20.1",
            20,
            1,
            new Url("http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.1.jpg"),
            new Url("http://www.professorfrancken.nl/franckenvrij/20.1.pdf")
        );

        $this->visit(action(
            [AdminFranckenVrijController::class, 'edit'],
            ['edition' => $edition->getId()]
        ))
            ->type('Clinical', 'title')
            ->type(20, 'volume')
            ->type(1, 'edition')
            ->press('Update');

        $this->see('Clinical');
    }

    /** @test */
    public function changing_a_published_francken_vrij_pdf_file() : void
    {
        $this->markTestSkipped('Github actions have issues with imagick');
        $edition = Edition::publish(
            EditionId::generate(),
            "Francken Vrij 20.1",
            20,
            1,
            new Url("http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.1.jpg"),
            new Url("http://www.professorfrancken.nl/franckenvrij/20.1.pdf")
        );

        $this->visit(action(
            [AdminFranckenVrijController::class, 'edit'],
            ['edition' => $edition->getId()]
        ))
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
        $edition = Edition::publish(
            EditionId::generate(),
            "Francken Vrij 20.1",
            20,
            1,
            new Url("http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.1.jpg"),
            new Url("http://www.professorfrancken.nl/franckenvrij/20.1.pdf")
        );

        $this->visit(action(
            [AdminFranckenVrijController::class, 'edit'],
            ['edition' => $edition->getId()]
        ))
            ->press('here');

        $this->dontSee('Clinical');
    }
}
