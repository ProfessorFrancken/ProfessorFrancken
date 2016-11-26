<?php

declare(strict_types=1);

namespace Francken\Tests\Application\FranckenVrij;

use Francken\Application\FranckenVrij\Edition;
use Francken\Application\FranckenVrij\Volume;
use Francken\Domain\FranckenVrij\EditionId;
use Francken\Domain\Url;
use PHPUnit_Framework_TestCase as TestCase;

class VolumeTest extends TestCase
{
    private $editions;

    public function setUp()
    {
        $this->editions = [
            Edition::publish(
                EditionId::generate(),
                'Francken Vrij',
                20,
                1,
                new Url('http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.1.jpg'),
                new Url('http://www.professorfrancken.nl/franckenvrij/20.1.pdf')
            ),
            Edition::publish(
                EditionId::generate(),
                'Francken Vrij',
                20,
                2,
                new Url('http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.2.jpg'),
                new Url('http://www.professorfrancken.nl/franckenvrij/20.2.pdf')
            ),
            Edition::publish(
                EditionId::generate(),
                'Francken Vrij',
                20,
                3,
                new Url('http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.3.jpg'),
                new Url('http://www.professorfrancken.nl/franckenvrij/20.3.pdf')
            ),
        ];
    }

    /** @test */
    function itisusedasacontainerofeditions()
    {
        $volume = new Volume(20, $this->editions);
        $this->assertEquals(20, $volume->volume());
        $this->assertEquals($this->editions, $volume->editions());
    }

    /** @test */
    function a_volume_cant_contain_editions_that_dont_belong_to_the_same_volume()
    {
        $this->expectException(\InvalidArgumentException::class);
        $volume = new Volume(21, $this->editions);
    }
}
