<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSearchProductsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'name' => ['nullable', 'min:1', ],
            'available' => ['nullable', 'boolean'],
            'category' => ['nullable', 'in:beer,food,soda,all'],
        ];
    }

    public function name() : ?string
    {
        return $this->input('name', '');
    }

    public function unavailable() : bool
    {
        return $this->exists('unavailable')
            ? (bool)$this->input('unavailable')
            : false;
    }

    public function category(string $select) : bool
    {
        $selected = $this->input('category', 'all');

        return $selected === $select;
    }
}
