<?php

declare(strict_types=1);

namespace Francken\Extern;

use DateTimeImmutable;
use Francken\Extern\Http\Requests\AdminSearchPartnersRequest;
use Francken\Extern\SponsorOptions\CompanyProfile;
use Francken\Extern\SponsorOptions\Footer;
use Francken\Extern\SponsorOptions\Vacancy;
use Illuminate\Database\Eloquent\Builder;
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
        'last_contract_ends_at',
    ];

    protected $casts = [
        'sector_id' => 'int',
        'logo_media_id' => 'int',
        'last_contract_ends_at' => 'date',
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

    public function scopeSearch(Builder $query, AdminSearchPartnersRequest $request) : Builder
    {
        return $query
            ->when($request->showArchived(), function (Builder $query, bool $showArchived) : void {
                if ($showArchived) {
                    $query->withTrashed();
                }
            })
            ->when($request->name(), function (Builder $query, string $name) : void {
                $query->where('name', 'LIKE', "%{$name}%");
            })
            ->when($request->sectorId(), function (Builder $query, int $sectorId) : void {
                $query->where('sector_id', '=', $sectorId);
            })
            ->when($request->status(), function (Builder $query, string $status) : void {
                $query->where('status', '=', $status);
            })
            ->when($request->hasCompanyProfile(), function (Builder $query, bool $hasCompanyProfile) : void {
                if ($hasCompanyProfile) {
                    $query->whereHas('companyProfile');
                }
            })
            ->when($request->hasFooter(), function (Builder $query, bool $hasFooter) : void {
                if ($hasFooter) {
                    $query->whereHas('footer');
                }
            })
            ->when($request->hasVacancies(), function (Builder $query, bool $hasVacancies) : void {
                if ($hasVacancies) {
                    $query->whereHas('vacancies');
                }
            });
    }

    public function scopeWithActiveContract(Builder $query, DateTimeImmutable $at) : Builder
    {
        return $query->whereDate('last_contract_ends_at', '>', $at);
    }

    public function scopeWithRecentlyExpiredContract(Builder $query, DateTimeImmutable $at) : Builder
    {
        return $query->whereDate('last_contract_ends_at', '>', $at->modify('-1 year'))
            ->whereDate('last_contract_ends_at', '<', $at);
    }

    public function scopeWithExpiredContract(Builder $query, DateTimeImmutable $at) : Builder
    {
        return $query->whereDate('last_contract_ends_at', '<', $at);
    }

    public function scopeWithAlumni(Builder $query) : Builder
    {
        return $query->whereHas('alumni');
    }
}
