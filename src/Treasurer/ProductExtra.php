<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Francken\Treasurer\ProductExtra
 *
 * @property int $product_id
 * @property string|null $splash_afbeelding
 * @property string|null $kleur kleur in hexcode
 * @property-read string|null $color
 * @property-read string|null $splash_url
 * @property-read Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductExtra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductExtra newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductExtra query()
 */
final class ProductExtra extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'product_id';

    /**
     * @var string
     */
    protected $table = 'producten_extras';

    /**
     * @var string
     */
    protected $connection = 'francken-legacy';

    /**
     * @var string[]
     */
    protected $fillable = [
        'splash_afbeelding',
        'kleur',
    ];

    public function getColorAttribute() : ?string
    {
        return $this->kleur;
    }

    public function getSplashUrlAttribute() : ?string
    {
        if ($this->splash_afbeelding === null) {
            return null;
        }

        if (Str::startsWith($this->splash_afbeelding, 'http')) {
            return $this->splash_afbeelding;
        }

        return "https://old.professorfrancken.nl/database/streep/afbeeldingen/{$this->splash_afbeelding}";
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
