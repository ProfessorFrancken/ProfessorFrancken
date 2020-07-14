<?php

declare(strict_types=1);

namespace Francken\Extern;

use Francken\Extern\SponsorOptions\CompanyProfile;
use Francken\Extern\SponsorOptions\Footer;
use Francken\Extern\SponsorOptions\Vacancy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;

final class Partner extends Model
{
    use SoftDeletes;
    use Mediable;

    /**
     * @var string
     */
    public const PARTNER_LOGO_TAG = 'partner_logo';

    /**
     * @var string
     */
    protected $table = 'extern_partners';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'sector_id',
        'logo_media_id',
        'homepage_url',
        'referral_url',
        'slug',
        'status',
    ];

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

    public function sector() : BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }

    public function companyProfile() : HasOne
    {
        return $this->hasOne(CompanyProfile::class);
    }

    public function footer() : HasOne
    {
        return $this->hasOne(Footer::class);
    }

    public function contactDetails() : HasOne
    {
        return $this->hasOne(ContactDetails::class)
            ->whereNull('contact_id')
            ->withDefault();
    }

    public function vacancies() : HasMany
    {
        return $this->hasMany(Vacancy::class);
    }

    public function contacts() : HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function alumni() : HasMany
    {
        return $this->hasMany(Alumnus::class);
    }

    public function notes() : HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function getReferralUrlAttribute() : string
    {
        return $this->attributes['referral_url'] ?? $this->homepage_url ?? '';
    }

    public function getDisplayStatusAttribute() : string
    {
        $status = PartnerStatus::all();

        return $status[$this->status] ?? '';
    }
}
