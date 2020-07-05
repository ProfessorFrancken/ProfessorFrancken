<?php

declare(strict_types=1);

namespace Francken\Association\News;

use Francken\Association\Boards\Board;

// Should include AuthorId, Link, Photo, Biography
final class Author
{
    private ?string $name = null;
    private ?string $photo = null;

    public function __construct(?string $name = '', ?string $photo = '')
    {
        $this->name = $name;
        $this->photo = $photo;
    }

    public static function fromBoard(Board $board) : self
    {
        return new self(
            $board->board_name->toString(),
            $board->photo ?? ''
        );
    }

    public function name() : string
    {
        return $this->name ?? '';
    }
    public function photo() : string
    {
        return $this->photo ?? '';
    }
}
