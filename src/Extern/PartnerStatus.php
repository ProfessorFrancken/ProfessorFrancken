<?php

declare(strict_types=1);

namespace Francken\Extern;

final class PartnerStatus
{
    public const ACTIVE_PARTNER = 'active_partner';
    public const POTENTIAL_PARTNER = 'potential_partner';
    public const PAST_PARTNER = 'past_partner';

    public static function all() : array
    {
        return [
                self::ACTIVE_PARTNER => 'Active partner',
                self::PAST_PARTNER => 'Past partner',
                self::POTENTIAL_PARTNER => 'Potential partner',
            ];
        }
}
