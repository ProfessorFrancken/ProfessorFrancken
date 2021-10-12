<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use Carbon\Carbon;
use Francken\Shared\Email;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;

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
    use SoftDeletes;
    use Mediable;

    /**
     * @var string
     */
    public const SYMPOSIUM_LOGO_TAG = 'symposium_logo';

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
        'location_google_maps_url',
        'start_date',
        'end_date',
        'website_url',
        'open_for_registration',
        'promote_on_agenda',
        'logo_media_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'open_for_registration' => 'boolean',
        'promote_on_agenda' => 'boolean',
        'logo_media_id' => 'int',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function registerParticipant(
        string $firstname,
        string $lastname,
        Email $email,
        bool $isFranckenMember,
        bool $isNnvMember,
        ?string $nnvNumber,
        bool $paysWithIban = false,
        ?string $iban = null,
        bool $freeLunch = false,
        bool $freeBorrelbox = false,
        string $lunchOption = null
    ) : Participant {
        $participant = $this->participants()->create([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => (string)$email,
            'is_francken_member' => $isFranckenMember,
            'is_nnv_member' => $isNnvMember,
            'nnv_number' => $nnvNumber,
            'pays_with_iban' => $paysWithIban,
            'iban' => encrypt($iban),

            'has_verified_email' => false,
            'has_paid' => false,

            'free_lunch' => $freeLunch,
            'free_borrelbox' => $freeBorrelbox,
            'lunch_option' => $lunchOption,
        ]);

        event(new ParticipantRegisteredForSymposium($participant));

        return $participant;
    }


    public function getLogoAttribute() : ?string
    {
        $logo = $this->logoMedia;

        if ($logo !== null) {
            return $logo->getUrl();
        }

        return null;
    }

    public function logoMedia() : BelongsTo
    {
        return $this->belongsTo(Media::class, 'logo_media_id');
    }

    public function participants() : HasMany
    {
        return $this->hasMany(Participant::class);
    }
}
