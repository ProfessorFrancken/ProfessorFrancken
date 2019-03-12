<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

final class Participant extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'association_symposium_participants';

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
}
