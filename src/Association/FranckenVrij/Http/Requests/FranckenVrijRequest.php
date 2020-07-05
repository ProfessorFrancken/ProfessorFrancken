<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FranckenVrijRequest extends FormRequest
{
    /**
     * @var int
     */
    private const ONE_HUNDRED_MB = 100 * 1024 * 1024;

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'title' => ['required'],
            'volume' => ['required', 'min:1'],
            'edition' => ['required', 'min:1', 'max:3'],
            'pdf' => ['nullable', 'file', 'max:' . self::ONE_HUNDRED_MB],
            'cover' => ['nullable', 'image', 'max:' . self::ONE_HUNDRED_MB]
        ];
    }

    public function title() : string
    {
        return $this->input('title');
    }

    public function volume() : int
    {
        return (int)$this->get('volume');
    }

    public function edition() : int
    {
        return (int)$this->get('edition');
    }
}
