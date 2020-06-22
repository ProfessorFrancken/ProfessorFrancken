<?php

declare(strict_types=1);

namespace Francken\Features\Repositories;

use Doctrine\Instantiator\Instantiator;
use Francken\Shared\ReadModelNotFound;
use Francken\Shared\ReadModelRepository;
use Francken\Shared\Serialization\Hydration\HydrateUsingReflection;
use Francken\Shared\Serialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator;
use Francken\Shared\Serialization\Reconstitution\Reconstitution;
use PHPUnit\Framework\TestCase as TestCase;

abstract class RepositoryTestCase extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();

        // Not 100% sure if this belongs here or in the implementations
        Reconstitution::reconstituteUsing(
            new ReconstituteUsingInstantiatorAndHydrator(
                new Instantiator(),
                new HydrateUsingReflection()
            )
        );
    }

    /** @test */
    public function it_saves_and_finds_a_model() : void
    {
        $repo = $this->createRepository();

        $model = $this->createReadModel('1', 'Some data', 'More data');

        $repo->save($model);

        $this->assertEquals($model, $repo->find('1'));
    }

    /** @test */
    public function it_cant_find_nonexisting_models() : void
    {
        $this->expectException(ReadModelNotFound::class);

        $repo = $this->createRepository();
        $repo->find('42');
    }

    /**
     * @group hoi
     * @test
     */
    public function it_finds_by_fields() : void
    {
        $repo = $this->createRepository();

        $model1 = $this->createReadModel('42', 'This', 'Hi');
        $model2 = $this->createReadModel('43', 'This', 'Hello');
        $model3 = $this->createReadModel('44', 'What', 'Hello');

        $repo->save($model1);
        $repo->save($model2);
        $repo->save($model3);

        $this->assertEquals([$model2], $repo->findBy([
            'first' => 'This',
            'second' => 'Hello'
        ]));
    }

    /** @test */
    public function looking_for_fields_that_dont_exist_will_have_no_result() : void
    {
        $repo = $this->createRepository();

        $model1 = $this->createReadModel('42', 'This', 'Hi');
        $model2 = $this->createReadModel('43', 'This', 'Hello');
        $model3 = $this->createReadModel('44', 'What', 'Hello');

        $repo->save($model1);
        $repo->save($model2);
        $repo->save($model3);

        $this->assertEquals([], $repo->findBy([
            'first' => 'This',
            'second' => 'Hello',
            'does-not-exist' => ''
        ]));
    }


    /** @test */
    public function it_returns_nothing_when_no_fields_are_set() : void
    {
        $repo = $this->createRepository();

        $model1 = $this->createReadModel('42', 'This', 'Hi');

        $repo->save($model1);

        $this->assertEmpty($repo->findBy([]));
    }

    /** @test */
    public function it_finds_all() : void
    {
        $repo = $this->createRepository();

        $model1 = $this->createReadModel('42', 'Some data', 'More');
        $model2 = $this->createReadModel('43', 'More data', 'Well hi');

        $repo->save($model1);
        $repo->save($model2);

        $this->assertEqualsCanonicalizing(
            [$model1, $model2],
            $repo->findAll()
        );
    }

    /** @test */
    public function it_finds_existing_ids() : void
    {
        $repo = $this->createRepository();

        $model1 = $this->createReadModel('42', 'Some data', 'Hi');
        $model2 = $this->createReadModel('43', 'More data', 'There');
        $model3 = $this->createReadModel('44', 'Last bit', 'Hello');

        $repo->save($model1);
        $repo->save($model2);
        $repo->save($model3);

        // None of the two exit
        $this->assertEmpty($repo->findByIds(['16', '12']));

        // Only one exists
        $this->assertEquals(
            [$model1],
            $repo->findByIds(['16', '42'])
        );

        // Both exist
        $this->assertEqualsCanonicalizing(
            [$model1, $model3],
            $repo->findByIds(['42', '44'])
        );
    }

    /** @test */
    public function it_removes_models() : void
    {
        $repo = $this->createRepository();

        $model = $this->createReadModel('42', 'First', 'Second');

        $repo->save($model);
        $repo->remove('42');

        $this->expectException(ReadModelNotFound::class);
        $repo->find('42');
    }

    /** @test */
    public function removing_unknown_models_is_done_without_throwing() : void
    {
        $repo = $this->createRepository();
        $model = $this->createReadModel('42', 'First', 'Second');

        $repo->save($model);
        $repo->remove('42');
        $repo->remove('42');

        $this->expectException(ReadModelNotFound::class);
        $repo->find('42');
    }

    /** @test */
    public function it_removes_by_fields_only_if_they_are_provided() : void
    {
        $repo = $this->createRepository();

        $model1 = $this->createReadModel('42', 'This', 'Hi');
        $model2 = $this->createReadModel('43', 'This', 'Hello');
        $model3 = $this->createReadModel('44', 'What', 'Hello');

        $repo->save($model1);
        $repo->save($model2);
        $repo->save($model3);

        // Remove nothing if nothing is provided
        $repo->removeBy([]);
        $this->assertEqualsCanonicalizing(
            [$model1, $model2, $model3],
            $repo->findAll()
        );

        // Removes the second model only
        $repo->removeBy([
            'first' => 'This',
            'second' => 'Hello',
        ]);

        $this->assertEqualsCanonicalizing(
            [$model1, $model3],
            $repo->findAll()
        );
    }

    /**
     * Return an instance of a read model
     */
    protected function createReadModel(string $id, string $first, string $second) : TestReadModel
    {
        return TestReadModel::create($id, $first, $second);
    }

    /**
     * Provide an instance of the repository that must be tested
     */
    abstract protected function createRepository() : ReadModelRepository;
}
