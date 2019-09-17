<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Members;

use Francken\Application\Projector;
use Francken\Application\ReadModel\MemberList\MemberList;
use Francken\Application\ReadModel\MemberList\MemberListProjector;
use Francken\Application\ReadModel\MemberList\MemberListRepository;
use Francken\Domain\Members\Events\MemberJoinedFrancken;
use Francken\Domain\Members\MemberId;
use Francken\Infrastructure\Repositories\InMemoryRepository;
use Francken\Tests\Application\ProjectorScenarioTestCase as TestCase;

class MemberListProjectorTest extends TestCase
{
    /** @test */
    public function it_stores_a_users_firstname_and_lastnaem() : void
    {
        $id = MemberId::generate();

        $this->scenario->when(
            new MemberJoinedFrancken($id, "Mark", "Redeman")
        )->then([
            new MemberList($id, "Mark", "Redeman")
        ]);
    }

    protected function createProjector(InMemoryRepository $repository) : Projector
    {
        return new MemberListProjector(
            new MemberListRepository(
                $repository
            )
        );
    }
}
