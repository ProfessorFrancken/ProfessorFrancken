<?php

declare(strict_types=1);

namespace Francken\Extern\Http\Requests;

use Francken\Association\Members\Gender;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'firstname' => ['required', 'regex:/[a-zA-Z0-9\s]+/', 'min:1'],
            'surname' => ['required', 'regex:/[a-zA-Z0-9\s]+/', 'min:1'],
            'initials' => [],
            'title' => ['nullable', 'regex:/[a-zA-Z0-9\s]+/', 'min:1'],
            'position' => ['nullable', 'regex:/[a-zA-Z0-9\s]+/', 'min:1'],

            'photo' => ['image', 'max:' . self::MAX_FILE_SIZE],

            'gender' => ['required', 'in:female,male,other'],
            'other_gender' => ['required_if:gener,other'],

            'notes' => ['nullable', 'regex:/[a-zA-Z0-9\s]+/', 'min:1'],
        ];
    }

    public function firstname() : string
    {
        return $this->input('firstname', '');
    }

    public function surname() : string
    {
        return $this->input('surname', '');
    }

    public function initials() : ?string
    {
        return $this->input('initials', '');
    }

    public function position() : string
    {
        return $this->input('position', '');
    }

    public function title() : ?string
    {
        return $this->input('title', '');
    }

    public function notes() : ?string
    {
        return $this->input('notes', '');
    }


    public function gender() : string
    {
        if ($this->input('gender') === Gender::FEMALE) {
            return Gender::FEMALE;
        }

        if ($this->input('gender') === Gender::MALE) {
            return Gender::MALE;
        }

        return $this->input('other_gender', '');
    }
}
