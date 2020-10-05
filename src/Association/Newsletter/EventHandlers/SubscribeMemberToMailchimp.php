<?php

declare(strict_types=1);

namespace Francken\Association\Newsletter\EventHandlers;

use Francken\Association\LegacyMember;
use Francken\Association\Members\Registration\Events\MemberWasRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\Newsletter\Newsletter;

final class SubscribeMemberToMailchimp implements ShouldQueue
{
    private Newsletter $newsletter;

    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    public function handle(MemberWasRegistered $event) : void
    {
        $member = LegacyMember::where('id', $event->registration->member_id)->firstOrFail();

        $this->newsletter->subscribe(
            $member->email->toString(),
            [
                "FNAME" => $member->voornaam,
                "LNAME" => $member->achternaam,
                "MMERGE3" => $member->jaar_van_inschrijving,
                "MMERGE4" => $member->id,
            ]
        );
    }
}
