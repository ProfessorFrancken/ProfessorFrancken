<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Carbon\Carbon;
use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public $timestamps = false;

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
    protected $casts = [
        'tijd' =>  'datetime',
        'prijs' => 'float',
        'totaalprijs' => 'float',
    ];

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

    public function purchasedBy() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class, 'lid_id');
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
