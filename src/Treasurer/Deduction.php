<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use League\Period\Period;

/**
 * Francken\Treasurer\Deduction
 *
 * @property int $id
 * @property Carbon $tijd
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read mixed $period
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Deduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Deduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Deduction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Deduction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Deduction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Deduction whereTijd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Deduction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class Deduction extends Model
{
    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var string
     */
    protected $table = 'afschrijvingen';

    /**
     * @var string
     */
    protected $connection = 'francken-legacy';

    /**
     * @var string[]
     */
    protected $dates = ['tijd'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'id', 'tijd', 'created_at', 'updated_at'
    ];

    public function previousDeduction() : self
    {
        /** @var Deduction */
        $deduction = self::orderBy('tijd', 'desc')
            ->where('tijd', '<', $this->tijd)
            ->firstOrFail();

        return $deduction;
    }

    public function getPeriodAttribute() : Period
    {
        return new Period(
            $this->previousDeduction()->tijd,
            $this->tijd
        );
    }
}
