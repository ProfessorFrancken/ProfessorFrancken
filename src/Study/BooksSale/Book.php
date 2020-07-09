<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale;

use Francken\Study\BooksSale\Http\Requests\AdminBookSearchRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property-read BookBuyer|null $buyer
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
 * @property-read BookSeller|null $seller
 * @method static \Illuminate\Database\Eloquent\Builder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder query()
 * @method static \Illuminate\Database\Eloquent\Builder whereAfgerekend($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereAuteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereBeschrijving($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereEditie($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereInkoopdatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereKoperid($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereNaam($value)
 * @method static \Illuminate\Database\Eloquent\Builder wherePrijs($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereVakid($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereVerkocht($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereVerkoopdatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereVerkoperid($value)
 * @method static \Illuminate\Database\Eloquent\Builder available()
 * @mixin \Eloquent
 */
final class Book extends Model
{
    /**
     * @var string
     */
    protected $table = 'study_booksale_books';
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'edition',
        'author',
        'description',
        'isbn',
        'price',
        'cover_url',

        'buyer_id',
        'seller_id',

        'taken_in_from_seller_at',
        'taken_in_by_buyer_at',

        'has_been_sold',
        'paid_off',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'taken_in_from_seller_at',
        'taken_in_by_buyer_at',
    ];

    public function seller() : BelongsTo
    {
        return $this->belongsTo(BookSeller::class);
    }

    public function buyer() : BelongsTo
    {
        return $this->belongsTo(BookBuyer::class);
    }

    public function getCoverPathAttribute() : string
    {
        $isbn = preg_replace("/[^0-9x]/i", '', $this->isbn);

        return 'http://images.amazon.com/images/P/' . $isbn . '.jpg';
    }

    public function scopeSearch(Builder $query, AdminBookSearchRequest $request) : Builder
    {
        return $query
            ->when($request->title(), function (Builder $query, string $title) : void {
                $query->where('title', 'LIKE', '%' . $title . '%');
            })
            ->when($request->sellerId(), function (Builder $query, int $sellerId) : void {
                $query->where('seller_id', $sellerId);
            })
            ->when($request->buyerId(), function (Builder $query, int $buyerId) : void {
                $query->where('buyer_id', $buyerId);
            });
    }

    public function scopeAvailable(Builder $query) : Builder
    {
        return $query
            ->where('taken_in_by_buyer_at', null)
            ->where('buyer_id', null)
            ->where('has_been_sold', false)
            ->where('paid_off', false);
    }

    public function scopeSold(Builder $query) : Builder
    {
        return $query->where('paid_off', false)
            ->where(function (Builder $query) : Builder {
                return $query->whereNotNull('taken_in_by_buyer_at')
                    ->orWhereNotNull('buyer_id')
                    ->orWhere('has_been_sold', true);
            });
    }

    public function scopePaidOff(Builder $query) : Builder
    {
        return $query->where('paid_off', true);
    }
}
