<?php

declare(strict_types=1);

namespace Francken\Association\Borrelcie\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AnytimerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'drinker_id' => ['required', 'integer', 'exists:borrelcie_accounts,id'],
            'owner_id' => ['required', 'integer', 'exists:borrelcie_accounts,id'],
            'amount' => ['required', 'integer'],
            'context' => ['in:given,claimed,drank,used'],
            'reason' => ['nullable'],
        ];
    }

    public function ownerId() : int
    {
        return (int) $this->input('owner_id');
    }

    public function drinkerId() : int
    {
        return (int) $this->input('drinker_id');
    }

    public function context() : string
    {
        return $this->input('context');
    }

    public function reason() : ?string
    {
        return $this->input('reason');
    }

    public function amount() : int
    {
        return (int) $this->input('amount');
    }
}
