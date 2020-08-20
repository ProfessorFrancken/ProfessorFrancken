<?php

declare(strict_types=1);

namespace Francken\Association\Members\Events;

use Francken\Association\LegacyMember;
use Illuminate\Queue\SerializesModels;

final class MemberPhoneNumberWasChanged
{
    use SerializesModels;

    private LegacyMember $member;
    private string $phoneNumber;
    private ?string $oldPhoneNumber;

    public function __construct(
        LegacyMember $member,
        string $phoneNumber,
        ?string $oldPhoneNumber
    ) {
        $this->member = $member;
        $this->phoneNumber = $phoneNumber;
        $this->oldPhoneNumber = $oldPhoneNumber;
    }

    public function member() : LegacyMember
    {
        return $this->member;
    }

    public function phoneNumber() : string
    {
        return $this->phoneNumber;
    }

    public function oldPhoneNumber() : ?string
    {
        return $this->oldPhoneNumber;
    }
}
