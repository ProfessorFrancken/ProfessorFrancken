<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Http\Requests;

use Francken\Shared\Email;
use Illuminate\Foundation\Http\FormRequest;

class ParticipantRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'firstname' => ['required', 'min:1'],
            'lastname' => ['required', 'min:1'],
            'email' => ['required', 'email'],
            'is_nnv_member' => ['nullable', 'boolean'],
            'is_francken_member' => ['nullable', 'boolean'],
            'member_id' => ['nullable', 'integer', 'exists:francken-legacy.leden,id'],
            'nnv_number' => ['required_if:is_nnv_member,1'],
            'pays_with_iban' => ['nullable', 'boolean'],
            'iban' => ['nullable', 'required_if:is_pays_with_iban,1', 'iban'],

            'free_lunch' => ['nullable', 'boolean'],
            'free_borrelbox' => ['nullable', 'boolean'],
        ];
    }

    public function firstname() : string
    {
        return $this->input('firstname', '');
    }

    public function lastname() : string
    {
        return $this->input('lastname', '');
    }

    public function email() : Email
    {
        return new Email($this->input('email', ''));
    }

    public function paysWithIban() : bool
    {
        return (bool)$this->input('pays_with_iban', false);
    }

    public function isNNVMember() : bool
    {
        return (bool)$this->input('is_nnv_member', false);
    }

    public function isFranckenMember() : bool
    {
        return (bool)$this->input('is_francken_member', false);
    }

    public function NNVNumber() : ?string
    {
        return $this->input('nnv_number');
    }

    public function memberId() : ?int
    {
        if ( ! $this->has('member_id')) {
            return null;
        }
        return (int)$this->input('member_id');
    }

    public function iban() : string
    {
        return $this->input('iban') ?? '';
    }

    public function freeLunch() : bool
    {
        return (bool)$this->input('free_lunch', false);
    }

    public function freeBorrelbox() : bool
    {
        return (bool)$this->input('free_borrelbox', false);
    }
}
