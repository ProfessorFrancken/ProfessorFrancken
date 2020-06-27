<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminBookSearchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['nullable', 'min:1', ],
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

    public function buyerId() : ?int
    {
        if ($this->input('buyer', '') === null) {
            return null;
        }

        $buyerId = (int)$this->input('buyer_id', '');

        return $buyerId === 0 ? null : $buyerId;
    }

    public function showSoldBooks() : ?bool
    {
        return $this->exists('show_sold_books')
            ? (bool)$this->input('show_sold_books')
            : null;
    }
}
