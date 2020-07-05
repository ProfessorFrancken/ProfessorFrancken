<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Francken\Treasurer\Transaction
 *
 * @property int $id
 * @property int $lid_id
 * @property int $product_id
 * @property int $aantal
 * @property float $prijs
 * @property float $totaalprijs
 * @property Carbon $tijd
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Transaction whereAantal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Transaction whereLidId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Transaction wherePrijs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Transaction whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Transaction whereTijd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Transaction whereTotaalprijs($value)
 * @mixin \Eloquent
 */
final class Transaction extends Model
{
    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var string
     */
    protected $table = 'transacties';

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
        "id",
        "lid_id",
        "product_id",
        "aantal",
        "prijs",
        "totaalprijs",
        "tijd",
    ];
}
