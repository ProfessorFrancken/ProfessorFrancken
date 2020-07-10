<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

final class Participant extends Model
{
    use Notifiable;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'association_symposium_participants';

    /**
     * @var string[]
     */
    protected $casts = [
        'received_information_mail' => 'boolean',
        "is_francken_member" => 'boolean',
        "is_nnv_member" => 'boolean',
        "pays_with_iban" => 'boolean',
        "has_registration" => 'boolean',
        "has_paid" => 'boolean',
        "is_spam" => 'boolean',
        'email_verified_at' => 'date',
    ];

    /**
     * @var string[]
     */
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

    public function getFullnameAttribute() : string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function verifyRegistration(DateTimeImmutable $verifiedAt) : void
    {
        $this->email_verified_at = $verifiedAt;
        $this->save();
    }

    public function symposium() : BelongsTo
    {
        return $this->belongsTo(Symposium::class);
    }

    public function adCount() : HasOne
    {
        return $this->hasOne(AdCount::class);
    }
}
