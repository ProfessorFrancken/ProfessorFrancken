<?php

declare(strict_types=1);

namespace Francken\Shared;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class Page extends Model
{
    protected $table = 'francken_pages';

    /**
     * @var string[]
     */
    protected $fillable = [
        'slug',
        'title',
        'description',
        'source_content',
        'compiled_content',
        'is_published',
    ];

    public function scopePublic(Builder $query) : Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeCovid(Builder $query) : Builder
    {
        return $query->where('slug', 'association/covid-19');
    }
}
