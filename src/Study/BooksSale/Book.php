<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;

/**
 * This code is somewhat odd, on the write side it uses our legacy, Dutch datbase.
 * On the read side it uses an English interface which we will migrate to.
 */
final class Book extends Model
{
    public $timestamps = false;
    protected $table = 'boeken';
    protected $connection = 'francken-legacy';
    protected $fillable = [
        'naam',
        'editie',
        'auteur',
        'beschrijving',
        'isbn',
        'prijs',

        'verkoperid',
        'koperid',

        'inkoopdatum',
        'verkoopdatum',

        'verkocht',
        'afgerekend',
    ];

    public function seller()
    {
        return $this->belongsTo(BookSeller::class, 'verkoperid');
    }

    public function buyer()
    {
        return $this->belongsTo(BookBuyer::class, 'koperid');
    }

    public function getTitleAttribute()
    {
        return $this->naam;
    }

    public function getDescriptionAttribute()
    {
        return $this->omschrijving;
    }

    public function getAuthorAttribute()
    {
        return $this->auteur;
    }

    public function getPriceAttribute()
    {
        return $this->prijs;
    }

    public function getPurchaseDateAttribute()
    {
        if ($this->inkoopdatum) {
            return new DateTimeImmutable($this->inkoopdatum);
        }

        return null;
    }

    public function getSaleDateAttribute()
    {
        if ($this->verkoopdatum) {
            return new DateTimeImmutable($this->verkoopdatum);
        }

        return null;
    }

    public function getEditionAttribute()
    {
        return (string)$this->editie;
    }

    public function getSoldAttribute() : bool
    {
        return $this->verkocht === 1;
    }

    public function getPaidOffAttribute() : bool
    {
        return $this->verkoct === 1;
    }

    public function putOnSaleAt()
    {
        return null;
    }

    public function getCoverPathAttribute() : string
    {
        return 'http://images.amazon.com/images/P/' . $this->isbn . '.jpg';
    }
}
