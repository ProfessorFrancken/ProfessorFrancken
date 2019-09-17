<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use Illuminate\Database\Eloquent\Model;

final class AdCount extends Model
{
    protected $table = 'association_symposium_ad_counts';
    protected $fillable = [
        'symposium_id',
        'participant_id',
        'name',
        'consumed',
    ];
}
