<?php

declare(strict_types=1);

namespace Francken\Domain\Members;

use Broadway\EventSourcing\EventSourcingRepository;

final class MemberRepository
{
    /**
     * @var EventSourcingRepository
     */
    private $repo;

    /**
     * MemberRepository constructor.
     * @param $repo
     */
    public function __construct(EventSourcingRepository $repo)
    {
        $this->repo = $repo;
    }

    
    public function load(MemberId $memberId) : Member
    {
        return $this->repo->load((string)$memberId);
    }

    
    public function save(Member $member) : void
    {
        $this->repo->save($member);
    }
}
