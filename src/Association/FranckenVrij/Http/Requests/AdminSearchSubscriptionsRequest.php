<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSearchSubscriptionsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'name' => ['nullable', 'min:1', ],
        ];
    }

    public function name() : ?string
    {
        return $this->input('name', '');
    }


    public function selected(string $select) : bool
    {
        $selected = $this->input('select', 'active-subscription');

        return $selected === $select;
    }
}
