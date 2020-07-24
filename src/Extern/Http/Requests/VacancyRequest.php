<?php

declare(strict_types=1);

namespace Francken\Extern\Http\Requests;

use Francken\Extern\JobType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VacancyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'title' => ['required', 'min:1'],
            'description' => ['nullable', 'min:1'],
            'sector_id' => ['nullable',  'exists:extern_partner_sectors,id'],
            'type' => ['required', Rule::in(
                JobType::all()
            )],
            'vacancy_url' => ['nullable', 'url'],
        ];
    }

    public function title() : string
    {
        return $this->input('title', '');
    }

    public function description() : string
    {
        return $this->input('description', '') ?? '';
    }

    public function sectorId() : int
    {
        return (int)$this->input('sector_id');
    }

    public function type() : string
    {
        return $this->input('type');
    }

    public function vacancyUrl() : ?string
    {
        return $this->input('vacancy_url', '');
    }
}
