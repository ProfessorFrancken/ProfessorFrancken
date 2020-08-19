<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

final class BoardMemberWasDischarged
{
    private int $boardId;

    private int $memberId;

    public function __construct(int $boardId, int $memberId)
    {
        $this->boardId = $boardId;
        $this->memberId = $memberId;
    }

    public function boardId() : int
    {
        return $this->boardId;
    }

    public function memberId() : int
    {
        return $this->memberId;
    }
}
