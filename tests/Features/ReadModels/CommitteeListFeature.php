<?php

namespace Tests\Features\ReadModels;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Francken\Committees\Committee;
use Francken\Committees\CommitteeId;
use Francken\Committees\CommitteeRepository;

class CommitteeListFeature extends TestCase
{
    use DatabaseMigrations;

    private $generator;
    private $repo;

    public function setUp()
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

        $this->seeInDatabase('committees_list', ['name' => 'S[ck]rip(t|t?c)ie', 'goal' => 'Digital anarchy']);
    }
}
