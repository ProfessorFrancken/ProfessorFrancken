<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Requests;

use Francken\Association\Boards\BoardMember;
use Francken\Association\Boards\BoardMemberStatus;
use Illuminate\Foundation\Http\FormRequest;

class KandiTotoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'president' => ['required', 'min:1'],
            'secretary' => ['required', 'min:1'],
            'treasurer' => ['required', 'min:1'],
            'intern' => ['required', 'min:1'],
            'extern' => ['required', 'min:1'],
            'wildcard' => ['nullable'],
        ];
    }

    public function boardMember() : BoardMember
    {
        return BoardMember::whereMemberId($this->user()->member_id)
            ->whereIn('board_member_status', [
                BoardMemberStatus::DEMISSIONED_BOARD_MEMBER,
                BoardMemberStatus::DECHARGED_BOARD_MEMBER,
            ])
            ->firstOrFail();
    }

    public function positions() : array
    {
        return [
            'president' => $this->input('president'),
            'secretary' => $this->input('secretary'),
            'treasurer' => $this->input('treasurer'),
            'intern' => $this->input('intern'),
            'extern' => $this->input('extern'),
            'wildcard' => $this->input('wildcard') ?? '',
        ];
    }
}
