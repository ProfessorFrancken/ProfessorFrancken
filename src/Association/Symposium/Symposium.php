<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use Francken\Domain\Members\Email;
use Illuminate\Database\Eloquent\Model;

final class Symposium extends Model
{
    protected $table = 'association_symposia';
    protected $fillable = [
        'name',
        'location',
        'start_date',
        'end_date',
        'website_url',
        'open_for_registration',
        'promote_on_agenda'
    ];

    protected $dates = [
        'start_date',
        'end_date'
    ];

    public function registerParticipant(
        string $firstname,
        string $lastname,
        Email $email,
        bool $is_francken_member,
        bool $is_nnv_member,
        ?string $nnv_number,
        bool $pays_with_iban = false,
        ?string $iban = null
    ) : Participant {
        $participant = $this->participants()->create([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => (string)$email,
            'is_francken_member' => $is_francken_member,
            'is_nnv_member' => $is_nnv_member,
            'nnv_number' => $nnv_number,
            'pays_with_iban' => $pays_with_iban,
            'iban' => encrypt($iban),

            'has_verified_email' => false,
            'has_paid' => false,
        ]);

        event(new ParticipantRegisteredForSymposium($participant));

        return $participant;
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
