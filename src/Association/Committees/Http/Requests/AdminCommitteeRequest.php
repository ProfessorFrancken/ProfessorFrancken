<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AdminCommitteeRequest extends FormRequest
{
    private const MAX_FILE_SIZE = 10 * 1024;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parent_committee_id' => ['nullable', 'exists:association_committees,id'],
            'name' => ['required', 'min:1'],
            'email' => ['nullable', 'email'],
            'goal' => ['nullable', 'min:1'],
            'is_public' => ['nullable', 'boolean'],
            'source_content' => ['nullable', 'min:1'],
            'logo' => ['image', 'max:' . self::MAX_FILE_SIZE],
            'photo' => ['image', 'max:' . self::MAX_FILE_SIZE],
        ];
    }

    public function name() : string
    {
        return $this->input('name');
    }

    public function slug() : string
    {
        return str_slug($this->name);
    }

    public function goal() : ?string
    {
        return $this->input('goal');
    }

    public function email() : ?string
    {
        return $this->input('email');
    }

    public function parentCommitteeId() : ?int
    {
        if ($this->input('parent_committee_id', '') === null) {
            return null;
        }

        $parentCommitteeId = (int)$this->input('parent_committee_id', '');

        return $parentCommitteeId === 0 ? null : $parentCommitteeId;
    }

    public function content() : string
    {
        return $this->input('source_content', '') ?? '';
    }

    public function isPublic() : bool
    {
        return (bool)$this->input('is_public');
    }
}
