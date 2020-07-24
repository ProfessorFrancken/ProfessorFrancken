<?php

declare(strict_types=1);

namespace Francken\Tests\Association\Newsletter\EventHandlers;

use Francken\Association\LegacyMember;
use Francken\Association\Members\Registration\Events\MemberWasRegistered;
use Francken\Association\Members\Registration\Registration;
use Francken\Association\Newsletter\EventHandlers\SubscribeMemberToMailchimp;
use Francken\Features\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Spatie\Newsletter\Newsletter;

final class SubscribeMemberToMailchimpTest extends TestCase
{
    use ProphecyTrait;

    /** @test */
    public function it_subscribes_a_newlly_registered_member_to_mailchimp() : void
    {
        $member = factory(LegacyMember::class)->create();
        $registration = new Registration();
        $registration->member_id = $member->id;

        $event = new MemberWasRegistered($registration);
        $newsletter = $this->prophesize(Newsletter::class);
        $handler = new SubscribeMemberToMailchimp($newsletter->reveal());

        $handler->handle($event);
        $newsletter->subscribe(
            $member->emailadres,
            [
                "FNAME" => $member->voornaam,
                "LNAME" => $member->achternaam,
                "MMERGE3" => $member->jaar_van_inschrijving,
                "MMERGE4" => $member->id,
            ]
        )->shouldHaveBeenCalledOnce();
    }
}
