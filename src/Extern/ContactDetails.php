<?php

declare(strict_types=1);

namespace Francken\Extern;

use Illuminate\Database\Eloquent\Model;

final class ContactDetails extends Model
{
    /**
     * @var string
     */
    protected $table = 'extern_partner_contact_details';

    /**
     * @var string[]
     */
    protected $fillable = [
        'email',
        'phone_number',
        'department',
        'city',
        'address',
        'postal_code',
        'country',
    ];

    public function getHasAddressAttribute() : bool
    {
        return $this->city !== null &&
            $this->address !== null &&
            $this->postal_code !== null &&
            $this->country !== null;
    }

    public function getHasEmailAttribute() : bool
    {
        return $this->email !== null;
    }

    public function getHasPhoneNumberAttribute() : bool
    {
        return $this->phone_number !== null;
    }
}
