<?php

declare(strict_types=1);

namespace Francken\Association\Events;

use Francken\Association\LegacyMember;
use Francken\Association\Members\Email;
use Illuminate\Queue\SerializesModels;

final class MemberEmailWasChanged
{
    use SerializesModels;

    private LegacyMember $member;
    private Email $email;
    private Email $oldEmail;
    private bool $subscriptionPreferenceWasChanged;

    public function __construct(
        LegacyMember $member,
        Email $email,
        Email $oldEmail,
        bool $subscriptionPreferenceWasChanged
    ) {
        $this->member = $member;
        $this->email = $email;
        $this->oldEmail = $oldEmail;
        $this->subscriptionPreferenceWasChanged = $subscriptionPreferenceWasChanged;
    }

    public function member() : LegacyMember
    {
        return $this->member;
    }

    public function email() : Email
    {
        return $this->email;
    }

    public function oldEmail(): Email
    {
        return $this->oldEmail;
    }

    public function subscriptionPreferenceWasChanged(): bool
    {
        return $this->subscriptionPreferenceWasChanged;
    }
}
