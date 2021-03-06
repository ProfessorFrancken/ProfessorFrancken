<?php

declare(strict_types=1);

namespace Francken\Association\Members\Events;

use Francken\Association\LegacyMember;
use Francken\Association\Members\Address;
use Illuminate\Queue\SerializesModels;

final class MemberAddressWasChanged
{
    use SerializesModels;

    private LegacyMember $member;
    private Address $address;
    private ?Address $oldAddress;

    public function __construct(
        LegacyMember $member,
        Address $address,
        ?Address $oldAddress
    ) {
        $this->member = $member;
        $this->address = $address;
        $this->oldAddress = $oldAddress;
    }

    public function member() : LegacyMember
    {
        return $this->member;
    }

    public function address() : Address
    {
        return $this->address;
    }

    public function oldAddress() : ?Address
    {
        return $this->oldAddress;
    }
}
