<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSearchRegistrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [];
    }

    public function selected(string $select) : bool
    {
        return $this->select() === $select;
    }

    public function select() : string
    {
        return $this->input('select', 'open');
    }

    public function searchQueryKeys(string $select) : array
    {
        return [
            'select' => $select
        ];
    }
}
