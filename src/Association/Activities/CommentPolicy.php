<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Francken\Auth\Account;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     */
    public function create(Account $account) : bool
    {
        return $account->member_id !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Account $account, Comment $comment) : bool
    {
        return $comment->member_id === $account->member_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Account $account, Comment $comment) : bool
    {
        return $comment->member_id === $account->member_id;
    }
}
