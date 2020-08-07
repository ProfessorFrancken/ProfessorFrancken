<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'plus_ones' => ['nullable', 'integer'],
            'dietary_wishes' => ['nullable', 'min:1'],
            'has_drivers_license' => ['nullable', 'boolean'],
        ];
    }

    public function plusOnes() : int
    {
        return (int) $this->input('plus_ones') ?? 0;
    }

    public function dietaryWishes() : string
    {
        return $this->input('dietary_wishes') ?? '';
    }

    public function hasDriversLicense() : bool
    {
        return (bool)$this->input('has_drivers_license', false);
    }
}
