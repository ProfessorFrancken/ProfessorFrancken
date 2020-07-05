<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Http\Requests;

use Francken\Study\BooksSale\BookBuyer;
use Francken\Study\BooksSale\BookSeller;
use Illuminate\Foundation\Http\FormRequest;

class AdminBookSearchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'title' => ['nullable', 'min:1', ],
            'seller_id' => ['nullable', 'integer', 'exists:francken-legacy.leden,id'],
            'buyer_id' => ['nullable', 'integer', 'exists:francken-legacy.leden,id'],
            'show_sold_books' => ['nullable', 'boolean'],
        ];
    }

    public function title() : ?string
    {
        return $this->input('title', '');
    }

    public function sellerId() : ?int
    {
        if ($this->input('seller', '') === null) {
            return null;
        }

        $sellerId = (int)$this->input('seller_id', '');

        return $sellerId === 0 ? null : $sellerId;
    }

    public function seller() : ?BookSeller
    {
        return $this->sellerId() !== null
            ? BookSeller::find($this->sellerId()) : null;
    }

    public function buyerId() : ?int
    {
        if ($this->input('buyer', '') === null) {
            return null;
        }

        $buyerId = (int)$this->input('buyer_id', '');

        return $buyerId === 0 ? null : $buyerId;
    }

    public function buyer() : ?BookBuyer
    {
        return $this->buyerId() !== null
            ? BookBuyer::find($this->buyerId())
            : null;
    }

    public function showSoldBooks() : ?bool
    {
        return $this->exists('show_sold_books')
            ? (bool)$this->input('show_sold_books')
            : null;
    }

    public function selected(string $select) : bool
    {
        $selected = $this->input('select', 'available');

        return $selected === $select;
    }
}
