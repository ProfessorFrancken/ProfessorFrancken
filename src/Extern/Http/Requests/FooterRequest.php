<?php

declare(strict_types=1);

namespace Francken\Extern\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FooterRequest extends FormRequest
{
    public const MAX_FILE_SIZE = 10 * 1024;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'is_enabled' => ['nullable', 'boolean'],
            'referral_url' => ['required', 'url'],
            'logo' => ['image', 'max:' . self::MAX_FILE_SIZE],
        ];
    }

    public function isActive() : bool
    {
        return (bool)$this->input('is_enabled', false);
    }

    public function referralUrl() : string
    {
        return $this->input('referral_url', '');
    }
}
