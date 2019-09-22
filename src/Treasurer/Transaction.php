<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Illuminate\Database\Eloquent\Model;

/**
 * Francken\Treasurer\Transaction
 *
 * @property int $id
 * @property int $lid_id
 * @property int $product_id
 * @property int $aantal
 * @property float $prijs
 * @property float $totaalprijs
 * @property \Illuminate\Support\Carbon $tijd
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
    public $timestamps = true;
    protected $table = 'transacties';
    protected $connection = 'francken-legacy';
    protected $dates = ['tijd'];
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
