<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Webmozart\Assert\Assert;

class PasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::min(8)],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages() : array
    {
        return [
            'current_password.password' => 'Please provide your current password.',
        ];
    }

    public function password() : string
    {
        $password = $this->input('password');

        Assert::minLength($password, 5);

        return $password;
    }
}
