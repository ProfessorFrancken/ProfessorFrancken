<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Members;

use Francken\Tests\Application\ReadModelTestCase as TestCase;
use Francken\Application\ReadModel\MemberList\MemberList;
use Francken\Domain\Members\MemberId;

class MemberListTest extends TestCase
{
    /** @test */
    function it_lists_a_users_first_and_last_name()
    {
        $id = MemberId::generate();
        $model = new MemberList($id, "Mark", "Redeman");

        $this->assertEquals((string)$id, $model->getId());
        $this->assertEquals($id, $model->memberId());
        $this->assertEquals("Mark", $model->firstName());
        $this->assertEquals("Redeman", $model->lastName());
    }

    protected function createInstance()
    {
        return new MemberList(MemberId::generate(), "Mark", "Redeman");
    }
}
