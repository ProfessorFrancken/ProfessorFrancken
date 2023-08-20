<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Francken\Treasurer\Http\Requests\AdminSearchProductsRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * Francken\Treasurer\Product
 *
 * @property int $id
 * @property string $naam
 * @property float $prijs
 * @property string $categorie
 * @property int $positie
 * @property bool $beschikbaar
 * @property string $afbeelding
 * @property string|null $splash_afbeelding
 * @property string $btw
 * @property int $eenheden
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Francken\Treasurer\ProductExtra|null $extra
 * @property-read bool $available
 * @property-read string $category
 * @property-read string $category_icon
 * @property-read string|null $color
 * @property-read string $name
 * @property-read string $photo_url
 * @property-read int $position
 * @property-read int $price
 * @property-read string|null $splash_url
 * @method static \Illuminate\Database\Eloquent\Builder|Product beer()
 * @method static \Illuminate\Database\Eloquent\Builder|Product food()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product search(\Francken\Treasurer\Http\Requests\AdminSearchProductsRequest $request)
 * @method static \Illuminate\Database\Eloquent\Builder|Product soda()
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
        'prijs' => 'float',
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

    public function extra() : HasOne
    {
        return $this->hasOne(ProductExtra::class);
    }

    public function getNameAttribute() : string
    {
        return $this->naam ?? '';
    }

    public function getPriceAttribute() : int
    {
        return (int)(100 * $this->prijs);
    }

    public function getAvailableAttribute() : bool
    {
        return (bool)$this->beschikbaar;
    }

    public function getCategoryAttribute() : string
    {
        $dutchToEnglish = [
            'Bier' => 'Beer',
            'Eten' => 'Food',
            'Fris' => 'Soda',
        ];

        return $dutchToEnglish[$this->categorie] ?? 'Unkown';
    }

    public function getCategoryIconAttribute() : string
    {
        $dutchToEnglish = [
            'Bier' => 'beer',
            'Eten' => 'drumstick-bite',
            'Fris' => 'coffee',
        ];

        return $dutchToEnglish[$this->categorie] ?? 'store';
    }

    public function getPhotoUrlAttribute() : string
    {
        if (Str::startsWith($this->afbeelding, 'http')) {
            return $this->afbeelding;
        }

        return "https://old.professorfrancken.nl/database/streep/afbeeldingen/{$this->afbeelding}";
    }

    public function getSplashUrlAttribute() : ?string
    {
        if ($this->extra === null) {
            return null;
        }
        return $this->extra->splash_url;
    }

    public function getColorAttribute() : ?string
    {
        if ($this->extra === null) {
            return null;
        }
        return $this->extra->color;
    }

    public function getPositionAttribute() : int
    {
        return $this->positie ?? 999;
    }

    public function scopeSearch(Builder $query, AdminSearchProductsRequest $request) : Builder
    {
        return $query
            ->when($request->name(), function (Builder $query, string $name) : void {
                $query->where('naam', 'LIKE', "%{$name}%");
            })
            ->when($request->unavailable(), function (Builder $query, bool $unavailable) : void {
                if ($unavailable) {
                    $query->where('beschikbaar', '=', false);
                }
            }, function (Builder $query) : void {
                $query->where('beschikbaar', '=', true);
            });
    }

    public function scopeBeer(Builder $query) : Builder
    {
        return $query->where("categorie", 'Bier');
    }

    public function scopeFood(Builder $query) : Builder
    {
        return $query->where("categorie", 'Eten');
    }

    public function scopeSoda(Builder $query) : Builder
    {
        return $query->where("categorie", 'Fris');
    }
}
