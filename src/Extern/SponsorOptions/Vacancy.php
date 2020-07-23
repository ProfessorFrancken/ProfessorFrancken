<?php

declare(strict_types=1);

namespace Francken\Extern\SponsorOptions;

use Francken\Extern\Http\Requests\SearchVacanciesRequest;
use Francken\Extern\Partner;
use Francken\Extern\Sector;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Vacancy extends Model
{
    /**
     * @var string
     */
    protected $table = 'extern_partner_vacancies';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'sector_id',
        'type',
        'vacancy_url',
    ];

    public function partner() : BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function sector() : BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }

    public function scopeSearch(Builder $query, SearchVacanciesRequest $request) : Builder
    {
        return $query
            ->when($request->title(), function (Builder $query, string $title) : void {
                $query->where('title', 'LIKE', "%{$title}%");
            })
            ->when($request->partnerId(), function (Builder $query, int $partnerId) : void {
                $query->where('partner_id', $partnerId);
            })
            ->when($request->sectorId(), function (Builder $query, int $sectorId) : void {
                $query->where('sector_id', '=', $sectorId);
            })
            ->when($request->jobType(), function (Builder $query, string $jobType) : void {
                $query->where('type', 'LIKE', "%$jobType%");
            });
    }
}
