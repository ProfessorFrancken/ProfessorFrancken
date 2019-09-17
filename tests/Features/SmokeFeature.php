<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Application\FranckenVrij\Edition;
use Francken\Application\FranckenVrij\FranckenVrijRepository;
use Francken\Domain\FranckenVrij\EditionId;
use Francken\Domain\Url;
use Illuminate\Foundation\Testing\DatabaseMigrations;

final class SmokeFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;


    public function setUp() : void
    {
        parent::setUp();
        $francken_vrij = $this->app->make(FranckenVrijRepository::class);
        $francken_vrij->save(
            Edition::publish(
                EditionId::generate(),
                "Francken Vrij 20.1",
                20,
                1,
                new Url("http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.1.jpg"),
                new Url("http://www.professorfrancken.nl/franckenvrij/20.1.pdf")
            )
        );
    }

    /**
     * @dataProvider pagesProvider
     * @test
     */
    public function it_should_be_able_to_serve_all_pages(string $url, int $expected_status) : void
    {
        $this->get($url)
            ->seeStatusCode($expected_status);
    }

    public function pagesProvider() : array
    {
        return [
            ["/", 200],
            ["/contact", 200],
            ["/study", 200],
            ["/study/books", 200],
            ["/study/research-groups", 200],
            ["/study/representation/university-council", 200],
            ["/study/representation/faculty-council", 200],
            ["/study/internationals", 200],
            ["/association", 200],
            ["/association/news", 200],
            ["/association/activities", 200],
            ["/association/history", 200],
            ["/association/honorary-members", 200],
            ["/association/boards", 200],
            ["/association/committees", 200],
            ["/association/francken-vrij", 200],
            ["/career", 200],
            ["/career/companies", 200],
            ["/career/job-openings", 200],
            ["/career/events", 302],
            ["/career/events/2017-2018", 200],
            ["photos", 302],
        ];
    }
}
