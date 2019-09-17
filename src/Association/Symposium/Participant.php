<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * Francken\Association\Symposium\Participant
 *
 * @property int $id
 * @property int $symposium_id
 * @property int|null $member_id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property bool $is_francken_member
 * @property bool $is_nnv_member
 * @property string|null $nnv_number
 * @property bool $pays_with_iban
 * @property string|null $iban
 * @property bool $has_registration
 * @property bool $has_paid
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_spam
 * @property bool $received_information_mail
 * @property-read \Francken\Association\Symposium\AdCount $adCount
 * @property-read mixed $full_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Francken\Association\Symposium\Symposium $symposium
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant newQuery()
 * @method static \Illuminate\Database\Query\Builder|\Francken\Association\Symposium\Participant onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereHasPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereHasRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereIsFranckenMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereIsNnvMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereIsSpam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereNnvNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant wherePaysWithIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereReceivedInformationMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereSymposiumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\Participant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Francken\Association\Symposium\Participant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Francken\Association\Symposium\Participant withoutTrashed()
 * @mixin \Eloquent
 */
final class Participant extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'association_symposium_participants';

    protected $casts = [
        'is_spam' => 'boolean',
        'received_information_mail' => 'boolean',
        "is_francken_member" => 'boolean',
        "is_nnv_member" => 'boolean',
        "pays_with_iban" => 'boolean',
        "has_registration" => 'boolean',
        "has_paid" => 'boolean',
        "is_spam" => 'boolean',
        'email_verified_at' => 'date',
    ];

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'is_francken_member',
        'is_nnv_member',
        'nnv_number',
        'pays_with_iban',
        'iban',
        'member_id',

        'email_verified_at',
        'has_paid',

        'is_spam',
        'received_information_mail',
    ];

    protected $dates = ['email_verified_at'];

    public function getFullNameAttribute() : string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function verifyRegistration(DateTimeImmutable $verified_at) : void
    {
        $this->email_verified_at = $verified_at;
        $this->save();
    }

    public function symposium()
    {
        return $this->belongsTo(Symposium::class);
    }

    public function adCount()
    {
        return $this->hasOne(AdCount::class);
    }
}
