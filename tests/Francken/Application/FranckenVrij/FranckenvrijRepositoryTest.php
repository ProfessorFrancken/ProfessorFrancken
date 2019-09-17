<?php

declare(strict_types=1);

namespace Francken\Tests\Application\FranckenVrij;

use Francken\Application\FranckenVrij\Edition;
use Francken\Application\FranckenVrij\FranckenVrijRepository;
use Francken\Domain\FranckenVrij\EditionId;
use Francken\Domain\Url;
use Francken\Infrastructure\Repositories\InMemoryRepository;
use PHPUnit\Framework\TestCase as TestCase;

class FranckenvrijRepositoryTest extends TestCase
{
    /** @test */
    public function it_returns_an_array_of_volumes() : void
    {
        $repo = new FranckenVrijRepository(
            new InMemoryRepository()
        );

        foreach (range(3, 1, -1) as $volume) {
            foreach (range(1, 3) as $edition) {
                $repo->save(
                    Edition::publish(
                        EditionId::generate(),
                        "Francken Vrij " . $volume . '.' . $edition,
                        $volume,
                        $edition,
                        new Url("http://www.professorfrancken.nl/franckenvrij/webplaatjes/{$volume}.{$edition}.jpg"),
                        new Url("http://www.professorfrancken.nl/franckenvrij/{$volume}.{$edition}.pdf")
                    )
                );
            }
        }

        $volumes = $repo->volumes();

        $this->assertCount(3, $volumes);
        $this->assertEquals(2, $volumes[1]->volume());
        $this->assertCount(3, $volumes[1]->editions());
    }
}
