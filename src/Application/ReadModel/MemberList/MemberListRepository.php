<?php

declare(strict_types=1);

namespace Francken\Application\ReadModel\MemberList;

use Francken\Application\ReadModelRepository;
use Francken\Domain\Members\MemberId;

final class MemberListRepository
{
    private $repo;

    public function __construct(ReadModelRepository $repo)
    {
        $this->repo = $repo;
    }

    public function save(MemberList $member)
    {
        $this->repo->save($member);
    }

    public function find(MemberId $id) : MemberList
    {
        return $this->repo->find((string)$id);
    }
}
