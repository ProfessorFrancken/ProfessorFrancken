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

    /**
     * @param MemberId $memberId
     * @return Member
     */
    public function load(MemberId $memberId) : Member
    {
        return $this->repo->load((string)$memberId);
    }

    /**
     * @param Member $member
     */
    public function save(Member $member)
    {
        $this->repo->save($member);
    }
}
