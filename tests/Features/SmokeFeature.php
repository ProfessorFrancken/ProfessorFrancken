<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\FranckenVrij\Edition;
use Francken\Association\FranckenVrij\EditionId;
use Francken\Shared\Url;

final class SmokeFeature extends TestCase
{
    use LoggedInAsAdmin;

    protected function setUp() : void
    {
        parent::setUp();
        Edition::publish(
            EditionId::generate(),
            "Francken Vrij 20.1",
            20,
            1,
            new Url("http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.1.jpg"),
            new Url("http://www.professorfrancken.nl/franckenvrij/20.1.pdf")
        );

        $board = Board::create([
            'name' => 'Hè Watt?',
            'installed_at' => '2017-06-06',
            'board_year_slug' => '2017-2018',
            'photo_position' => '',
        ]);
        Committee::create([
            'board_id' => $board->id,
            'name' => 'S[ck]rip(t|t?c)ie',
            'slug' => 'scriptcie',
            'is_public' => true,
        ]);
    }

    /**
     * @dataProvider pagesProvider
     * @test
     */
    public function it_should_be_able_to_serve_all_pages(string $url, int $expectedStatus) : void
    {
        $this->get($url)
            ->seeStatusCode($expectedStatus);
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
            ["/association/committees", 302],
            ["/association/2017-2018/committees", 200],
            ["/association/2017-2018/committees/scriptcie", 200],
            ["/association/francken-vrij", 200],
            ["/association/almanak", 200],
            ["/career", 200],
            ["/career/companies", 200],
            ["/career/job-openings", 200],
            ["photos", 302],
        ];
    }
}
