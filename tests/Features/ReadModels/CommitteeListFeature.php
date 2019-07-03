<?php

declare(strict_types=1);

namespace Francken\Features\ReadModels;

use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Francken\Domain\Committees\Committee;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\CommitteeRepository;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommitteeListFeature extends TestCase
{
    use DatabaseMigrations;

    private $generator;
    private $repo;

    public function setUp() : void
    {
        parent::setUp();

        $this->generator = new Version4Generator();
        $this->repo = app(CommitteeRepository::class);
    }

    /**
     * @test
     */
    public function a_list_of_all_new_committees_is_kept()
    {
        $id = new CommitteeId($this->generator->generate());
        $committee = Committee::instantiate($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy');

        $this->repo->save($committee);

        $this->seeInDatabase('committees_list', ['name' => 'S[ck]rip(t|t?c)ie', 'summary' => 'Digital anarchy']);
    }
}
