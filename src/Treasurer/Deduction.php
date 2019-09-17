<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Illuminate\Database\Eloquent\Model;
use League\Period\Period;

final class Deduction extends Model
{
    public $timestamps = true;
    protected $table = 'afschrijvingen';
    protected $connection = 'francken-legacy';
    protected $dates = ['tijd'];
    protected $fillable = [
        'id', 'tijd', 'created_at', 'updated_at'
    ];

    public function previousDeduction() : self
    {
        return self::orderBy('tijd', 'desc')
            ->where('tijd', '<', $this->tijd)
            ->firstOrFail();
    }

    public function getPeriodAttribute() : Period
    {
        return new Period(
            $this->previousDeduction()->tijd,
            $this->tijd
        );
    }
}
