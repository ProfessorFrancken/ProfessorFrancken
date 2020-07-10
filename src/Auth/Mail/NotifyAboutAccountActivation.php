<?php

declare(strict_types=1);

namespace Francken\Auth\Mail;

use Francken\Auth\Account;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyAboutAccountActivation extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var string
     */
    public $theme = 'francken';

    private int $accountId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(int $accountId)
    {
        $this->accountId = $accountId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(PasswordBroker $broker) : self
    {
        $account = Account::findOrFail($this->accountId);

        return $this->subject("Your Francken website account was activated")
            ->markdown('auth.mails.notify-about-account-activation', [
                'fullname' => $account->member->fullname,
                'email' => $account->email,
                'url' => $this->resetLink($account, $broker),
            ]);
    }

    private function resetLink(Account $account, PasswordBroker $broker) : string
    {
        // $broker = \App::make(PasswordBroker::class);

        return route('password.reset', ['token' => $broker->createToken($account)]);
    }
}
