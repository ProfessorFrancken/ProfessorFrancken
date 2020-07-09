<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

final class BoardMemberWasDemissioned
{
    private int $board_id;
   
    private int $member_id;

    public function __construct(int $boardId, int $memberId)
    {
        $this->board_id = $boardId;
        $this->member_id = $memberId;
    }

    public function boardId() : int
    {
        return $this->board_id;
    }

    public function memberId() : int
    {
        return $this->member_id;
    }
}
