<?php

declare(strict_types=1);

namespace Francken\Association\Members\Notifications;

use Francken\Association\Activities\Http\ActivitiesController;
use Francken\Association\Members\Http\ExpensesController;
use Francken\Association\Members\Http\ProfileController;
use Francken\Association\Photos\Http\Controllers\PhotosController;
use Francken\Auth\Account;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Webmozart\Assert\Assert;

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
        /** @var Account $account */
        $account = Account::findOrFail($this->accountId);
        Assert::notNull($account->member);

        return $this->subject("Your Francken website account was activated")
            ->markdown('association.members.registration.mail.account-was-activated', [
                'fullname' => $account->member->fullname,
                'email' => $account->email,
                'password_reset_url'=> $this->resetLink($account, $broker),

                'expenses_url' => action([ExpensesController::class, 'index']),
                'photos_url' => action([PhotosController::class, 'index']),
                'activities_url' => action([ActivitiesController::class, 'index']),
                'profile_url' => action([ProfileController::class, 'index']),
            ]);
    }

    private function resetLink(Account $account, PasswordBroker $broker) : string
    {
        return route('password.reset', ['token' => $broker->createToken($account)]);
    }
}
