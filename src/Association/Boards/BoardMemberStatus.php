<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

use DateTimeInterface;

class BoardMemberStatus
{
    /**
     * @var string
     */
    public const CANDIDATE = 'candidate';
    /**
     * @var string
     */
    public const BOARD_MEMBER = 'board_member';
    /**
     * @var string
     */
    public const DEMISSIONED_BOARD_MEMBER = 'demissioned_board_member';
    /**
     * @var string
     */
    public const DECHARGED_BOARD_MEMBER = 'decharged_board_member';

    public static function fromDates(
        DateTimeInterface $currentDate,
        DateTimeInterface $installedAt,
        ?DateTimeInterface $demissionedAt = null,
        ?DateTimeInterface $dechargedAt = null
    ) : string {
        if (isset($dechargedAt) && $currentDate > $dechargedAt) {
            return static::DECHARGED_BOARD_MEMBER;
        }

        if (isset($demissionedAt) && $currentDate > $demissionedAt) {
            return static::DEMISSIONED_BOARD_MEMBER;
        }

        if ($currentDate > $installedAt) {
            return static::BOARD_MEMBER;
        }

        return static::CANDIDATE;
    }
}
