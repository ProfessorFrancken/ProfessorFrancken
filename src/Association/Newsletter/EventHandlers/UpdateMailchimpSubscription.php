<?php

declare(strict_types=1);

namespace Francken\Association\Newsletter\EventHandlers;

use Francken\Association\LegacyMember;
use Francken\Association\Members\Events\MemberEmailWasChanged;
use Francken\Shared\Email;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\Newsletter\Newsletter;

final class UpdateMailchimpSubscription implements ShouldQueue
{
    private Newsletter $newsletter;

    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    public function handle(MemberEmailWasChanged $event) : void
    {
        $member = $event->member();

        $currentEmail = $event->oldEmail();
        $this->updateSubscription($member, $currentEmail);

        $newEmail = $event->email();
        $this->updateEmail($currentEmail, $newEmail);
    }

    private function updateSubscription(LegacyMember $member, Email $email) : void
    {
        if ( ! $this->newsletter->hasMember($email->toString())) {
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

        $isSubscribed = $this->newsletter->isSubscribed($email->toString());
        if ( ! $isSubscribed && $member->receive_newsletter) {
            $this->newsletter->subscribe($email->toString());
            return;
        }

        if ($isSubscribed && ! $member->receive_newsletter) {
            $this->newsletter->unsubscribe($email->toString());
            return;
        }
    }

    private function updateEmail(Email $currentEmail, Email $newEmail) : void
    {
        if ($currentEmail == $newEmail) {
            return;
        }
        $this->newsletter->updateEmailAddress(
            $currentEmail->toString(),
            $newEmail->toString()
        );
    }
}
