<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

final class BoardMemberWasDemissioned
{
    private int $board_id;
   
    private int $member_id;

    public function __construct(int $board_id, int $member_id)
    {
        $this->board_id = $board_id;
        $this->member_id = $member_id;
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
