<?php


declare(strict_types=1);

namespace Francken\Shared\Http\Requests;

use Francken\Association\Boards\Board;
use Francken\Association\Boards\BoardMember;
use Illuminate\Foundation\Http\FormRequest;

class BoardDashboardRequest extends FormRequest
{
    public function rules() : array
    {
        return [];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        $account = $this->user();

        if ( ! $account) {
            return false;
        }


        if ($account->hasRole('Admin')) {
            return true;
        }

        return $this->board()
            ->members
            ->contains(fn (BoardMember $member) => $member->member_id === $account->member_id);
    }

    public function board() : Board
    {
        return Board::current()->firstOrFail();
    }
}
