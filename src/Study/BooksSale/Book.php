<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale;

use Francken\Study\BooksSale\Http\Requests\AdminBookSearchRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected $casts = [
        'taken_in_from_seller_at' => 'date',
        'taken_in_by_buyer_at' => 'date',

        'price' => 'int',
        'buyer_id' => 'int',
        'seller_id' => 'int',

        'has_been_sold' => 'boolean',
        'paid_off' => 'boolean',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
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
        if ($this->isbn === null) {
            return '';
        }
        $isbn = preg_replace("/[^0-9x]/i", '', $this->isbn);

        return 'https://covers.openlibrary.org/b/isbn/' . $isbn . '-L.jpg';
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
            ->where(fn (Builder $query) : Builder => $query->whereNotNull('taken_in_by_buyer_at')
                ->orWhereNotNull('buyer_id')
                ->orWhere('has_been_sold', true));
    }

    public function scopePaidOff(Builder $query) : Builder
    {
        return $query->where('paid_off', true);
    }
}
