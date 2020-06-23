<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Association\FranckenVrij\EditionId;
use Francken\Association\FranckenVrij\FranckenVrijEdition;
use Francken\Shared\Url;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FrontPageFeature extends TestCase
{
    use DatabaseMigrations;

    /**
     * Checks if we can open the front page
     *
     * @test
     */
    public function the_front_page_shows_our_name() : void
    {
        $this->publishAFranckenVrij();

        $this->visit('/')
             ->see("T.F.V. 'Professor Francken'");
    }


    private function publishAFranckenVrij() : void
    {
        FranckenVrijEdition::publish(
            EditionId::generate(),
            "Francken Vrij 20.1",
            20,
            1,
            new Url("http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.1.jpg"),
            new Url("http://www.professorfrancken.nl/franckenvrij/20.1.pdf")
        );
    }
}
