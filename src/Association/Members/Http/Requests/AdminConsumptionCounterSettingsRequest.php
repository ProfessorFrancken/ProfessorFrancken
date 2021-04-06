<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminConsumptionCounterSettingsRequest extends FormRequest
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
            'prominent' => ['nullable', 'integer'],
            'kleur' => ['nullable'],
            'bijnaam' => ['nullable'],
            'small_button' => ['nullable', 'boolean'],
            'image' => ['image', 'max:' . self::MAX_FILE_SIZE],
        ];
    }

    public function prominent() : ?string
    {
        return $this->input('prominent', '');
    }

    public function color() : ?string
    {
        return $this->input('kleur', '');
    }

    public function nickname() : ?string
    {
        return $this->input('bijnaam', '');
    }

    public function smallButton() : bool
    {
        return (bool)$this->input('small_button', false);
    }

    public function buttonWidth() : ?int
    {
        return $this->smallButton() ? 50 : null;
    }

    public function buttonHeight() : ?int
    {
        return $this->smallButton() ? 50 : null;
    }
}
