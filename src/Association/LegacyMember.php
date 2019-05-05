<?php

declare(strict_types=1);

namespace Francken\Association;

use Illuminate\Database\Eloquent\Model;

final class LegacyMember extends Model
{
    protected $table = 'leden';
    protected $connection = 'francken-legacy';

    public function getFullNameAttribute()
    {
        return collect([
            $this->voornaam,
            $this->tussenvoegsel,
            $this->achternaam
        ])->filter()->implode(' ');
    }
}
