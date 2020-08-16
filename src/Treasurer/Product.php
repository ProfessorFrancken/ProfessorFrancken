<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Francken\Treasurer\Http\Requests\AdminSearchProductsRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

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
        if ( ! $this->extra) {
            return null;
        }
        return $this->extra->splash_url;
    }

    public function getColorAttribute() : ?string
    {
        if ( ! $this->extra) {
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
