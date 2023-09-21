<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class AdminPhotoRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'name' => ['required', 'min:1'],
            'visibility' => ['required', Rule::in(['private', 'public', 'members-only'])],
        ];
    }

    public function name() : string
    {
        return $this->string('name')->toString();
    }

    public function visibility() : string
    {
        return $this->string('visibility', 'members-only')->toString();
    }
}
