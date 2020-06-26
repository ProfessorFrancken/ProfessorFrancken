<?php

declare(strict_types=1);

namespace Francken\Extern\Http\Requests;

use Francken\Extern\ContactDetails;
use Illuminate\Foundation\Http\FormRequest;

class ContactDetailsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['nullable', 'email'],
            'department' => ['nullable', 'min:1'],
            'city' => ['nullable', 'min:1', 'required_with:address,postal_code,country'],
            'address' => ['nullable', 'min:1',  'required_with:city,postal_code,country'],
            'postal_code' => ['nullable', 'min:1',  'required_with:city,address,country'],
            'country' => ['nullable', 'min:1',  'required_with:city,address,postal_code'],
            'phone_number' => ['nullable', 'min:1'],
        ];
    }

    public function contactDetails() : ContactDetails
    {
        return new ContactDetails([
            'email' => $this->input('email', null),
            'phone_number' => $this->input('phone_number', null),
            'department' => $this->input('department', null),
            'city' => $this->input('city', null),
            'address' => $this->input('address', null),
            'postal_code' => $this->input('postal_code', null),
            'country' => $this->input('country', null),
        ]);
    }
}
