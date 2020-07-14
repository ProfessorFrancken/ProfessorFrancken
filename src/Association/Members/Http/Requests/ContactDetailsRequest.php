<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http\Requests;

use Francken\Association\Members\Address;
use Francken\Shared\Email;
use Illuminate\Foundation\Http\FormRequest;

class ContactDetailsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'email' => ['required', 'email'],
            'city' => ['nullable', 'min:1', 'required_with:address,postal_code,country'],
            'address' => ['nullable', 'min:1',  'required_with:city,postal_code,country'],
            'postal_code' => ['nullable', 'min:1',  'required_with:city,address,country'],
            'country' => ['nullable', 'min:1',  'required_with:city,address,postal_code'],
            'phone_number' => ['nullable', 'min:1'],

            'newsletter' => [],
            'francken_vrij' => [],
        ];
    }

    public function email() : Email
    {
        return new Email($this->input('email'));
    }

    public function address() : Address
    {
        return new Address(
                $this->input('city') ?? '',
                $this->input('postal_code') ?? '',
                $this->input('address') ?? '',
                $this->input('country') ?? ''
            );
    }

    public function phoneNumber() : string
    {
        return $this->input('phone_number') ?? '';
    }

    public function mailinglistMail() : bool
    {
        return (bool) $this->input('newsletter');
    }

    public function mailinglistFranckenVrij() : bool
    {
        return (bool) $this->input('francken_vrij');
    }
}
