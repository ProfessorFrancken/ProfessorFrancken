<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale;

use Illuminate\Database\Eloquent\Model;

final class BookBuyer extends Model
{
    protected $table = 'leden';
    protected $connection = 'francken-legacy';
    public function getFullNameAttribute() : string
    {
        return collect([$this->voornaam, $this->tussenvoegsel, $this->achternaam])
            ->filter()
            ->implode(' ');
    }
}
