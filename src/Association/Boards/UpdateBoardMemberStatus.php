<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;

/**
 * Since we allow users to set the installed, decharged and demissioned dates
 */
final class UpdateBoardMemberStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boards:update-board-member-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the status of board members whose install, demission or decharge dates may have been set in the future.';

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        // NOTE: we could make this command more efficient by only searching for
        // board members whose status isn't equal to their actual status, which
        // requires us to (among others) look for all members whose demissioned
        // and decharged date hasn't been set, install date is later than today
        // and whose status isn't BoardMemberStatus::BOARD_MEMBER
        // But since we don't have that many board members and this commadn will
        // likely only be run once per day, I'm fine whith this simple implementation
        /** @var Collection */
        $members = BoardMember::all();

        $members->each(function (BoardMember $member) : void {
            $member->refreshStatus();
        });
    }
}
