<?php

declare(strict_types=1);

namespace Francken\Tests\Application;

use Broadway\Domain\DateTime;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use Broadway\ReadModel\Projector;
use Francken\Application\ReadModelRepository;
use PHPUnit\Framework\TestCase;

final class Scenario
{
    private $testCase;
    private $projector;
    private $repository;
    private $playhead;
    private $aggregateId;

    public function __construct(
        TestCase $testCase,
        ReadModelRepository $repository,
        Projector $projector
    ) {
        $this->testCase = $testCase;
        $this->repository = $repository;
        $this->projector = $projector;
        $this->playhead = -1;
        $this->aggregateId = 1;
    }

    /**
     * @param string $aggregateId
     * @return Scenario
     */
    public function withAggregateId(string $aggregateId)
    {
        $this->aggregateId = $aggregateId;

        return $this;
    }

    /**
     * @param array $events
     * @return Scenario
     */
    public function given(array $events = array())
    {
        foreach ($events as $given) {
            $this->projector->handle($this->createDomainMessageForEvent($given));
        }

        return $this;
    }

    /**
     * @param mixed $event
     * @param DateTime $occurredOn
     * @return Scenario
     */
    public function when($event, DateTime $occurredOn = null)
    {
        $this->projector->handle($this->createDomainMessageForEvent($event, $occurredOn));

        return $this;
    }

    /**
     * @param array $expectedData
     * @return Scenario
     */
    public function then(array $expectedData)
    {
        $this->testCase->assertEquals($expectedData, $this->repository->findAll());

        return $this;
    }

    private function createDomainMessageForEvent($event, DateTime $occurredOn = null) : DomainMessage
    {
        $this->playhead++;

        if (null === $occurredOn) {
            $occurredOn = DateTime::now();
        }

        return new DomainMessage($this->aggregateId, $this->playhead, new Metadata, $event, $occurredOn);
    }
}
