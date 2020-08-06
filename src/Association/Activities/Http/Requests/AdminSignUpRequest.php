<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSignUpRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'member_id' => ['required', 'integer', 'exists:francken-legacy.leden,id'],
            'plus_ones' => ['required', 'integer'],
            'notes' => ['nullable'],
            'dietary_wishes' => ['nullable', 'min:1'],
            'has_drivers_license' => ['nullable', 'boolean'],
        ];
    }

    public function memberId() : int
    {
        return (int) $this->input('member_id');
    }

    public function plusOnes() : int
    {
        return (int) $this->input('plus_ones');
    }

    public function notes() : string
    {
        return $this->input('notes') ?? '';
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
