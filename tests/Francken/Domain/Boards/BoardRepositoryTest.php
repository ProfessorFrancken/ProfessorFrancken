<?php

declare(strict_types=1);

namespace Tests\Francken\Domain\Boards;

use DateTimeImmutable;
use Francken\Domain\Boards\BoardRepository;
use PHPUnit_Framework_TestCase as TestCase;

final class BoardRepositoryTest extends TestCase
{
    /** @test */
    function it_finds_a_board_that_was_active_during_some_date()
    {
        $boards = new BoardRepository;

        $buitengewoon = $boards->boardDuringDate(
            new DateTimeImmutable('2017-01-01')
        );

        $this->assertEquals('Buitengewoon', $buitengewoon->name());
    }

}
