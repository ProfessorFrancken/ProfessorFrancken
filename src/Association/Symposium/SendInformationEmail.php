<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\Mailer;
use Webmozart\Assert\Assert;

final class SendInformationEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'symposia:send-information-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an information email to new participants';

    /**
     * @var Mailer
     */
    private $mail;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Mailer $mail)
    {
        parent::__construct();

        $this->mail = $mail;
    }

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        // Fetch all participants that could be interested in an information mail
        $participants = Participant::where('is_spam', false)
            ->where('received_information_mail', false)
            ->get();

        if ( ! $this->confirm("Send information email to {$participants->count()} participants?")) {
            return;
        }

        foreach ($participants as $participant) {
            $this->sendinformationemail($participant);
        }
    }

    private function sendInformationEmail(Participant $participant) : void
    {
        Assert::false($participant->received_information_mail);

        $this->mail->to($participant->email)
            ->send(new Mail\InformationEmail($participant));

        $participant->received_information_mail = true;
        $participant->save();
    }
}
