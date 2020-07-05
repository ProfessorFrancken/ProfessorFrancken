<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use Francken\Shared\Email;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Francken\Association\Symposium\Symposium
 *
 * @property int $id
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property string $name
 * @property string $location
 * @property string $website_url
 * @property int $open_for_registration
 * @property int $promote_on_agenda
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Participant[] $participants
 * @property-read int|null $participants_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Symposium newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Symposium newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Symposium query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Symposium whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Symposium whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Symposium whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Symposium whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Symposium whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Symposium whereOpenForRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Symposium wherePromoteOnAgenda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Symposium whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Symposium whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Symposium whereWebsiteUrl($value)
 * @mixin \Eloquent
 */
final class Symposium extends Model
{
    /**
     * @var string
     */
    protected $table = 'association_symposia';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'location',
        'start_date',
        'end_date',
        'website_url',
        'open_for_registration',
        'promote_on_agenda'
    ];

    /**
     * @var string[]
     */
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

    public function participants() : HasMany
    {
        return $this->hasMany(Participant::class);
    }
}
