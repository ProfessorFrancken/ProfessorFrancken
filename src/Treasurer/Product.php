<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Illuminate\Database\Eloquent\Model;

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
