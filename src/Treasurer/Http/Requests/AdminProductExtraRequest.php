<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AdminProductExtraRequest extends FormRequest
{
    /**
     * @var int
     */
    private const MAX_FILE_SIZE = 10 * 1024;

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'color' => ['nullable'],
            'splash_photo' => ['image', 'max:' . self::MAX_FILE_SIZE],
        ];
    }

    public function color() : string
    {
        return $this->input('color');
    }
}
