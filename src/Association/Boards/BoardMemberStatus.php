<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

use DateTimeImmutable;

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
        DateTimeImmutable $current_date,
        DateTimeImmutable $installed_at,
        ?DateTimeImmutable $demissioned_at = null,
        ?DateTimeImmutable $decharged_at = null
    ) : string {
        if (isset($decharged_at) && $current_date > $decharged_at) {
            return static::DECHARGED_BOARD_MEMBER;
        }

        if (isset($demissioned_at) && $current_date > $demissioned_at) {
            return static::DEMISSIONED_BOARD_MEMBER;
        }

        if ($current_date > $installed_at) {
            return static::BOARD_MEMBER;
        }

        return static::CANDIDATE;
    }
}
