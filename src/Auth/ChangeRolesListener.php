<?php

declare(strict_types=1);

namespace Francken\Auth;

use Francken\Application\Committees\Committee;
use Francken\Application\Committees\CommitteesRepository;
use Spatie\Permission\Models\Role;

final class ChangeRolesListener
{
    public const ACTIVE_MEMBER_ROLE = 'Active member';

    /**
     * @var Role
     */
    private $roles;

    /**
     * @var CommitteesRepository
     */
    private $committees;

    public function __construct(Role $roles, CommitteesRepository $committees)
    {
        $this->roles = $roles;
        $this->committees = $committees;
    }

    public function handle($event) : void
    {
        $method = $this->getHandleMethod($event);

        if ( ! method_exists($this, $method)) {
            return;
        }

        $this->$method($event);
    }

    public function whenAccountWasActivated(
        AccountWasActivated $event
    ) : void {
        $account = Account::find($event->accountId());

        $committees = $this->committees->ofMember($account->member_id);

        foreach ($committees as $committee) {
            $account->assignRole(
                $this->roleForCommittee($committee)
            );
        }
    }

    private function roleForCommittee(Committee $committee)
    {
        return Role::firstOrCreate([
            'name' => $this->committeeRoleName($committee)
        ]);
    }

    private function committeeRoleName(Committee $committee) : string
    {
        return 'Committee ' . $committee->name();
    }

    private function getHandleMethod($event)
    {
        $classParts = explode('\\', get_class($event));

        return 'when' . end($classParts);
    }
}
