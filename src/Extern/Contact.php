<?php

declare(strict_types=1);

namespace Francken\Extern;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;

final class Contact extends Model
{
    use Mediable;
    use SoftDeletes;

    public const CONTACT_PHOTO_TAG = 'partner_contact_photo';

    protected $table = 'extern_partner_contacts';
    protected $fillable = [
        'firstname',
        'surname',
        'title',
        'initials',
        'gender',
        'position',
        'notes',
        'photo_media_id',
    ];

    public function contactDetails() : HasOne
    {
        return $this->hasOne(ContactDetails::class)
            ->withDefault(['partner_id' => $this->partner_id]);
    }

    public function getPhotoAttribute() : ?string
    {
        $photo = $this->getMedia(static::CONTACT_PHOTO_TAG)->last();

        if ($photo !== null) {
            return $photo->getUrl();
        }

        return null;
    }

    public function scopeWithPhotos($query)
    {
        return $query->withMedia([static::CONTACT_PHOTO_TAG]);
    }

    public function getFullnameAttribute() : string
    {
        return $this->firstname . ' ' . $this->surname;
    }
}
