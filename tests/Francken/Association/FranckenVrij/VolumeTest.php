<?php

declare(strict_types=1);

namespace Francken\Tests\Association\FranckenVrij;

use Francken\Association\FranckenVrij\EditionId;
use Francken\Association\FranckenVrij\FranckenVrijEdition;
use Francken\Association\FranckenVrij\Volume;
use Francken\Shared\Url;
use PHPUnit\Framework\TestCase as TestCase;

class VolumeTest extends TestCase
{
    private $editions;

    public function setUp() : void
    {
        $this->editions = [
            new FranckenVrijEdition([
                'id' => EditionId::generate(),
                'title' => 'Francken Vrij',
                'volume' => 20,
                'edtion' => 1,
                'pdf' => new Url('http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.1.jpg'),
                'cover' => new Url('http://www.professorfrancken.nl/franckenvrij/20.1.pdf')
            ]),
            new FranckenVrijEdition([
                'id' => EditionId::generate(),
                'title' => 'Francken Vrij',
                'volume' => 20,
                'edtion' => 2,
                'pdf' => new Url('http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.2.jpg'),
                'cover' => new Url('http://www.professorfrancken.nl/franckenvrij/20.2.pdf')
            ]),
            new FranckenVrijEdition([
                'id' => EditionId::generate(),
                'title' => 'Francken Vrij',
                'volume' => 20,
                'edtion' => 3,
                'pdf' => new Url('http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.3.jpg'),
                'cover' => new Url('http://www.professorfrancken.nl/franckenvrij/20.3.pdf')
            ]),
        ];
    }

    /** @test */
    public function it_is_used_as_a_container_of_editions() : void
    {
        $volume = new Volume(20, $this->editions);
        $this->assertEquals(20, $volume->volume());
        $this->assertEquals($this->editions, $volume->editions());
    }

    /** @test */
    public function a_volume_cant_contain_editions_that_dont_belong_to_the_same_volume() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Volume(21, $this->editions);
    }
}
