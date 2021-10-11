<?php

declare(strict_types=1);

namespace Francken\Association\AlumniActivity\Http;

use Illuminate\Foundation\Http\FormRequest;

class AdminAlumnusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'member_id' => ['nullable', 'integer', 'exists:francken-legacy.leden,id'],
            'fullname' => ['required', 'min:1'],
            'study' => ['required', 'min:1'],
            'graduation_year' => ['nullable', 'integer'],
        ];
    }

    public function memberId() : int
    {
        return (int) $this->input('member_id');
    }

    public function fullname() : string
    {
        return $this->input('fullname');
    }

    public function graduationYear() : ?int
    {
        $graduationYear = $this->input('graduation_year', null);

        if ($graduationYear !== null) {
            return (int) $graduationYear;
        }
        return null;
    }

    public function study() : string
    {
        return $this->input('study') ?? '';
    }
}
