<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

final class BoardWasInstalled
{
    /**
     * @var int
     */
    private $board_id;

    public function __construct(int $board_id)
    {
        $this->board_id = $board_id;
    }

    public function boardId() : int
    {
        return $this->board_id;
    }
}
