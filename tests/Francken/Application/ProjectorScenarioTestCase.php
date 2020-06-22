<?php

declare(strict_types=1);

namespace Francken\Tests\Application;

use Francken\Shared\Projector;
use Francken\Infrastructure\Repositories\InMemoryRepository;
use PHPUnit\Framework\TestCase as TestCase;

abstract class ProjectorScenarioTestCase extends TestCase
{
    /**
     * @var Scenario
     */
    protected $scenario;

    public function setUp() : void
    {
        $this->scenario = $this->createScenario();
    }

    protected function createScenario() : Scenario
    {
        $repository = new InMemoryRepository();

        return new Scenario($this, $repository, $this->createProjector($repository));
    }

    abstract protected function createProjector(InMemoryRepository $repository) : Projector;
}
