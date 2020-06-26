<?php

declare(strict_types=1);

namespace Francken\Extern\Http\Requests;

use Francken\Extern\PartnerStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminSearchPartnersRequest extends FormRequest
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
            // 'sector_id' => ['sometimes', 'nullable', 'exists:extern_partner_sectors,id'],
            // 'status' => ['sometimes', 'nullable', Rule::in(
            //     array_keys(PartnerStatus::all())
            // )],
            'has_company_profile' => ['nullable', 'boolean'],
            'has_footer' => ['nullable', 'boolean'],
            'has_vacancies' => ['nullable', 'boolean'],
            'show_archived' => ['nullable', 'boolean'],
        ];
    }

    public function name() : ?string
    {
        return $this->input('name', '');
    }

    public function sectorId() : ?int
    {
        $sectorId = (int)$this->input('sector_id', '');

        return $sectorId === 0 ? null : $sectorId;
    }

    public function status() : ?string
    {
        $status = $this->input('status', '');

        return $status == '0' ? null : $status;
    }

    public function hasCompanyProfile() : ?bool
    {
        return $this->exists('has_company_profile')
            ? (bool)$this->input('has_company_profile')
            : null;
    }

    public function hasFooter() : ?bool
    {
        return $this->exists('has_footer')
            ? (bool)$this->input('has_footer')
            : null;
    }

    public function hasVacancies() : ?bool
    {
        return $this->exists('has_vacancies')
            ? (bool)$this->input('has_vacancies')
            : null;
    }

    public function showArchived() : ?bool
    {
        return $this->exists('show_archived')
            ? (bool)$this->input('show_archived')
            : null;
    }
}
