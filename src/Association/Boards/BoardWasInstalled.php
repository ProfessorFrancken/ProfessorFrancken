<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

final class BoardWasInstalled
{
    private int $board_id;

    public function __construct(int $boardId)
    {
        $this->board_id = $boardId;
    }

    public function boardId() : int
    {
        return $this->board_id;
    }
}
