<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Illuminate\Database\Eloquent\Model;

final class Photo extends Model
{
    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
