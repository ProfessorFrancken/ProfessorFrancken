<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

final class BoardWasInstalled
{
    private int $boardId;

    public function __construct(int $boardId)
    {
        $this->boardId = $boardId;
    }

    public function boardId() : int
    {
        return $this->boardId;
    }
}
