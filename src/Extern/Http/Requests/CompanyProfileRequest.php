<?php

declare(strict_types=1);

namespace Francken\Extern\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'display_name' => ['nullable', 'min:1'],
            'is_enabled' => ['nullable', 'boolean'],
            'source_content' => ['required', 'min:1'],
        ];
    }

    public function displayName() : ?string
    {
        return $this->input('display_name', '');
    }

    public function isActive() : bool
    {
        return (bool)$this->input('is_enabled', false);
    }

    public function content() : string
    {
        return $this->input('source_content', '');
    }
}
