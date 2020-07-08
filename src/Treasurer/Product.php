<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Illuminate\Database\Eloquent\Model;

/**
 * Francken\Treasurer\Product
 *
 * @property int $id
 * @property string $naam
 * @property int $prijs
 * @property string $categorie
 * @property int $positie
 * @property bool $beschikbaar
 * @property string $afbeelding
 * @property float $btw
 * @property int $eenheden
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $name
 * @property-read int $price
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\Product query()
 */
final class Product extends Model
{
    /**
     * @var string
     */
    protected $table = 'producten';

    /**
     * @var string
     */
    protected $connection = 'francken-legacy';

    protected $casts = [
        'prijs' => 'integer',
        'eenheden' => 'integer',
        'beschikbaar' => 'boolean'
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'naam',
        'prijs',
        'categorie',
        'positie',
        'beschikbaar',
        'afbeelding',
        'btw',
        'eenheden',
    ];

    public function getNameAttribute() : string
    {
        return $this->naam;
    }

    public function getPriceAttribute() : int
    {
        return $this->prijs;
    }
}
