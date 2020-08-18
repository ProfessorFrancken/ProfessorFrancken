<?php

declare(strict_types=1);

namespace Francken\Association\Members\EventHandlers;

use Francken\Association\Members\Notifications\NotifyAboutAccountActivation;
use Francken\Association\Members\Registration\Events\MemberWasRegistered;
use Francken\Auth\Account;
use Francken\Auth\AccountWasActivated;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;

final class ActivateAccount implements ShouldQueue
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

    public function handle(object $event) : void
    {
        $method = $this->getHandleMethod($event);

        if ( ! method_exists($this, $method)) {
            return;
        }

        $this->$method($event);
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
        $account = Account::findOrFail($event->accountId());

        $this->mail->to($account->email)
            ->queue(new NotifyAboutAccountActivation($account->id));
    }

    private function getHandleMethod(object $event) : string
    {
        $classParts = explode('\\', get_class($event));

        return 'when' . end($classParts);
    }
}
