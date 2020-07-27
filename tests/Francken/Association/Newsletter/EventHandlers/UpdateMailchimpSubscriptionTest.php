<?php

declare(strict_types=1);

namespace Francken\Tests\Association\Newsletter\EventHandlers;

use Francken\Association\LegacyMember;
use Francken\Association\Members\Events\MemberEmailWasChanged;
use Francken\Association\Newsletter\EventHandlers\UpdateMailchimpSubscription;
use Francken\Features\TestCase;
use Francken\Shared\Email;
use Prophecy\PhpUnit\ProphecyTrait;
use Spatie\Newsletter\Newsletter;

final class UpdateMailchimpSubscriptionTest extends TestCase
{
    use ProphecyTrait;

    /** @test */
    public function it_subscribes_members_if_they_are_not_subscribed() : void
    {
        $member = factory(LegacyMember::class)->create([
            'mailinglist_email' => true
        ]);
        $event = new MemberEmailWasChanged(
            $member,
            $member->email,
            $member->email,
            true
        );

        $newsletter = $this->prophesize(Newsletter::class);
        $newsletter->hasMember($member->email->toString())->willReturn(false);
        $newsletter->isSubscribed($member->email->toString())->willReturn(true);

        $handler = new UpdateMailchimpSubscription($newsletter->reveal());
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

    /** @test */
    public function it_updates_a_members_subscription_email() : void
    {
        $member = factory(LegacyMember::class)->create([
            'mailinglist_email' => true,
            'emailadres' => 'markredeman@gmail.com',
        ]);
        $newEmail = new Email('markredeman+new@gmail.com');
        $event = new MemberEmailWasChanged(
            $member,
            $newEmail,
            $member->email,
            true
        );

        $newsletter = $this->prophesize(Newsletter::class);
        $newsletter->hasMember($member->email->toString())->willReturn(true);
        $newsletter->isSubscribed($member->email->toString())->willReturn(true);
        $newsletter->updateEmailAddress(
            $member->email,
            $newEmail
        )->shouldBeCalledOnce();

        $handler = new UpdateMailchimpSubscription($newsletter->reveal());
        $handler->handle($event);
    }

    /** @test */
    public function it_unsubscribes_a_member() : void
    {
        $member = factory(LegacyMember::class)->create([
            'mailinglist_email' => false,
        ]);
        $event = new MemberEmailWasChanged(
            $member,
            $member->email,
            $member->email,
            true
        );

        $newsletter = $this->prophesize(Newsletter::class);
        $newsletter->hasMember($member->email->toString())->willReturn(true);
        $newsletter->isSubscribed($member->email->toString())->willReturn(true);
        $newsletter->unsubscribe($member->email)->shouldBeCalledOnce();

        $handler = new UpdateMailchimpSubscription($newsletter->reveal());
        $handler->handle($event);
    }

    /** @test */
    public function it_resubscribes_a_member() : void
    {
        $member = factory(LegacyMember::class)->create([
            'mailinglist_email' => true,
        ]);
        $event = new MemberEmailWasChanged(
            $member,
            $member->email,
            $member->email,
            true
        );

        $newsletter = $this->prophesize(Newsletter::class);
        $newsletter->hasMember($member->email->toString())->willReturn(true);
        $newsletter->isSubscribed($member->email->toString())->willReturn(false);
        $newsletter->subscribe($member->email)->shouldBeCalledOnce();

        $handler = new UpdateMailchimpSubscription($newsletter->reveal());
        $handler->handle($event);
    }
}
