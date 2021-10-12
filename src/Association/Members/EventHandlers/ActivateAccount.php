<?php

declare(strict_types=1);

namespace Francken\Association\Members\EventHandlers;

use Francken\Association\Members\Notifications\NotifyAboutAccountActivation;
use Francken\Association\Members\Registration\Events\MemberWasRegistered;
use Francken\Auth\Account;
use Francken\Auth\AccountWasActivated;
use Francken\Shared\EventHandler;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;

final class ActivateAccount extends EventHandler implements ShouldQueue
{
    private Hasher $hash;
    private Mailer $mail;

    public function __construct(
        Hasher $hasher,
        Mailer $mailer
    ) {
        $this->hash = $hasher;
        $this->mail = $mailer;
    }

    public function whenMemberWasRegistered(MemberWasRegistered $event) : void
    {
        $memberId = $event->registration->member_id;

        Assert::integer($memberId);

        $randomPassword = $this->hash->make(Str::random(32));

        Account::activate(
            $memberId,
            $event->registration->email->toString(),
            $randomPassword
        );
    }

    public function whenAccountWasActivated(AccountWasActivated $event) : void
    {
        /** @var Account $account */
        $account = Account::findOrFail($event->accountId());

        $this->mail->to($account->email)
            ->queue(new NotifyAboutAccountActivation($account->id));
    }
}
