<?php


declare(strict_types=1);

namespace Francken\Association\Members\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSearchMembersRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'firstname' => ['nullable', 'min:1', ],
            'surname' => ['nullable', 'min:1', ],
            'email' => ['nullable', 'min:1', ],
            'study' => ['nullable'],
            'type' => ['nullable']
        ];
    }

    public function firstname() : ?string
    {
        return $this->input('firstname', '');
    }

    public function surname() : ?string
    {
        return $this->input('surname', '');
    }

    public function email() : ?string
    {
        return $this->input('email', '');
    }

    public function study() : ?string
    {
        return $this->input('study', '');
    }

    public function type() : ?string
    {
        return $this->input('type', '');
    }

    public function selected(string $select) : bool
    {
        return $this->select() === $select;
    }

    public function select() : string
    {
        return $this->input('select', 'all');
    }

    public function searchQueryKeys(string $select) : array
    {
        return [
            'firstname' => $this->firstname(),
            'surname' => $this->surname(),
            'email' => $this->email(),
            'study' => $this->study(),
            'type' => $this->type(),
            'select' => $select
        ];
    }
}
