<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * This code is somewhat odd, on the write side it uses our legacy, Dutch datbase.
 *
 * On the read side it uses an English interface which we will migrate to.
 *
 * @property int $id
 * @property string|null $naam
 * @property int|null $editie
 * @property string|null $isbn
 * @property string|null $auteur
 * @property int|null $vakid
 * @property int|null $verkoperid
 * @property int|null $koperid
 * @property int|null $prijs price in whole euros
 * @property string|null $beschrijving
 * @property string|null $inkoopdatum
 * @property string|null $verkoopdatum
 * @property string|null $link
 * @property int|null $afgerekend
 * @property int|null $verkocht
 * @property-read \Francken\Study\BooksSale\BookBuyer|null $buyer
 * @property-read mixed $author
 * @property-read mixed $cover_path
 * @property-read mixed $description
 * @property-read mixed $edition
 * @property-read mixed $paid_off
 * @property-read mixed $price
 * @property-read mixed $purchase_date
 * @property-read mixed $sale_date
 * @property-read mixed $sold
 * @property-read mixed $title
 * @property-read \Francken\Study\BooksSale\BookSeller|null $seller
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book whereAfgerekend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book whereAuteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book whereBeschrijving($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book whereEditie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book whereInkoopdatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book whereKoperid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book whereNaam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book wherePrijs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book whereVakid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book whereVerkocht($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book whereVerkoopdatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book whereVerkoperid($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Study\BooksSale\Book available()
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

    public function scopeAvailable(Builder $query) : Builder
    {
        return $query
            ->where('verkoopdatum', null)
            ->where('verkocht', false)
            ->where('afgerekend', false);
    }

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
        return $this->beschrijving;
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
        return $this->verkocht === 1;
    }

    public function putOnSaleAt()
    {
        return null;
    }

    public function getCoverPathAttribute() : string
    {
        return 'http://images.amazon.com/images/P/' . $this->isbn . '.jpg';
    }

    public function title() : string
    {
        return $this->naam ?? '';
    }

    public function author() : string
    {
        return $this->auteur ?? '';
    }

    public function pathToCover() : string
    {
        return $this->cover_path;
    }

    public function price() : int
    {
        return $this->prijs * 100;
    }
    public function bookId() : int
    {
        return $this->id;
    }

    public function getNameAttribute() : string
    {
        return $this->naam ?? '';
    }

    public function getPriceBySellerAttribute() : int
    {
        // In euros
        return $this->prijs;
    }

    public function getTakenInFromSellerAtAttribute() : ?DateTimeImmutable
    {
        return null;
    }

    public function getTakenInByBuyerAtAttribute() : ?DateTimeImmutable
    {
        return null;
    }
}
