<?php

declare(strict_types=1);

namespace Francken\Extern;

final class PartnerStatus
{
    /**
     * @var string
     */
    public const PRIMARY_PARTNER = 'main_partner';
    /**
     * @var string
     */
    public const SECONDARY_PARTNER = 'secondary_partner';
    /**
     * @var string
     */
    public const ACTIVE_PARTNER = 'active_partner';
    /**
     * @var string
     */
    public const POTENTIAL_PARTNER = 'potential_partner';
    /**
     * @var string
     */
    public const PAST_PARTNER = 'past_partner';
    /**
     * @var string
     */
    public const OTHER_PARTNER = 'other_partner';

    public static function all() : array
    {
        return [
            self::PRIMARY_PARTNER => 'Main partner',
            self::SECONDARY_PARTNER => 'Secondary partner',
            self::ACTIVE_PARTNER => 'Active partner',
            self::PAST_PARTNER => 'Past partner',
            self::POTENTIAL_PARTNER => 'Potential partner',
            self::OTHER_PARTNER => 'Other',
        ];
    }
}
