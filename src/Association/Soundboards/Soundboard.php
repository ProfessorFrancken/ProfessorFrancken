<?php

declare(strict_types=1);

namespace Francken\Association\Soundboards;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Soundboard extends Model
{
    /**
     * @var string
     */
    protected $table = 'association_soundboards';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    public function sounds() : HasMany
    {
        return $this->hasMany(Sound::class);
    }
}
