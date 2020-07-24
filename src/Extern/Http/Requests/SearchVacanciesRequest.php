<?php

declare(strict_types=1);

namespace Francken\Extern\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchVacanciesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'title' => ['nullable', 'min:1', ],
            'job_type' => ['nullable', 'min:1'],
        ];
    }

    public function title() : ?string
    {
        return $this->input('title', '');
    }

    public function partnerId() : ?int
    {
        $partnerId = (int)$this->input('partner_id', '');

        return $partnerId === 0 ? null : $partnerId;
    }

    public function sectorId() : ?int
    {
        $sectorId = (int)$this->input('sector_id', '');

        return $sectorId === 0 ? null : $sectorId;
    }

    public function jobType() : ?string
    {
        return $this->input('job_type', '');
    }
}
