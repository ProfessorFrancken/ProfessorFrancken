<?php

declare(strict_types=1);

namespace Francken\Application\News;

use Francken\Domain\Boards\Board;
use Francken\Domain\Boards\BoardId;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Identifier;
use Francken\Domain\Members\MemberId;

// Should include AuthorId, Link, Photo, Biography
final class Author
{
    private $name;
    private $photo;

    public function __construct(string $name, string $photo = '')
    {
        $this->name = $name;
        $this->photo = $photo;
    }

    public static function fromBoard(Board $board) : self
    {
        return new Author(
            'Board ' . $board->name(),
            $board->photo()
        );
    }

    public function name() : string
    {
        return $this->name;
    }
    public function photo() : string
    {
        return $this->photo;
    }
}
