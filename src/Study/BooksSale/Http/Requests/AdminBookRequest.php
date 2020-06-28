<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Http\Requests;

use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Webmozart\Assert\Assert;

class AdminBookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'min:3', ],
            'edition' => ['nullable', 'integer'],
            'author' => ['required', 'min:1', ],
            'description' => ['nullable', 'min:1', ],
            'price' => ['required', 'min:1'],

            'isbn' => ['required', 'isbn', 'min:1', ],

            'seller_id' => ['nullable', 'integer', 'exists:francken-legacy.leden,id'],
            'purchase_date' => ['required', 'date_format:Y-m-d'],

            'buyer_id' => ['nullable', 'integer', 'exists:francken-legacy.leden,id'],
            'sale_date' => ['nullable', 'date_format:Y-m-d', 'required_with:buyer_id'],
            'sold' => ['nullable', 'boolean', 'required_with:buyer_id,paid_off'],

            'paid_off' => ['nullable', 'boolean'],
        ];
    }

    public function title() : ?string
    {
        return $this->input('title', '');
    }

    public function edition() : ?int
    {
        return $this->exists('edition')
            ? (int) $this->input('edition')
            : null;
    }

    public function author() : ?string
    {
        return $this->input('author');
    }

    public function description() : ?string
    {
        return $this->input('description', '');
    }

    public function price() : int
    {
        return (int)$this->input('price', null);
    }

    public function sellerId() : ?int
    {
        if ($this->input('seller', '') === null) {
            return null;
        }

        $sellerId = (int)$this->input('seller_id', '');

        return $sellerId === 0 ? null : $sellerId;
    }

    public function seller() : ?string
    {
        return ($this->sellerId() !== null)
            ? $this->input('seller', '')
            : null;
    }

    public function purchaseDate() : DateTimeImmutable
    {
        $purchaseDate = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $this->input('purchase_date')
        );

        Assert::isInstanceOf($purchaseDate, DateTimeImmutable::class);

        return $purchaseDate;
    }

    public function buyerId() : ?int
    {
        if ($this->input('buyer', '') === null) {
            return null;
        }

        $buyerId = (int) $this->input('buyer_id', '');

        return $buyerId === 0 ? null : $buyerId;
    }

    public function buyer() : ?string
    {
        return ($this->buyerId() !== null)
            ? $this->input('buyer', '')
            : null;
    }

    public function saleDate() : ?DateTimeImmutable
    {
        if ($this->input('sale_date') === null) {
            return null;
        }

        $saleDate = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $this->input('sale_date')
        );

        Assert::isInstanceOf($saleDate, DateTimeImmutable::class);

        return $saleDate;
    }

    public function hasBeenSold() : ?bool
    {
        return  (bool)$this->input('sold');
    }

    public function hasBeenPaidOff() : ?bool
    {
        return  (bool)$this->input('paid_off');
    }

    public function isbn() : ?string
    {
        return preg_replace("/[^0-9x]/i", '', $this->input('isbn'));
    }

    public function isbn10() : ?string
    {
        $isbn = $this->isbn();

        return (strlen($isbn) === 10) ? $isbn : null;
    }

    public function isbn13() : ?string
    {
        $isbn = $this->isbn();

        return (strlen($isbn) === 13) ? $isbn : null;
    }
}
