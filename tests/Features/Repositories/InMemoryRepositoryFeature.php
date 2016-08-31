<?php

declare(strict_types=1);

namespace Francken\Features\Repositories;

use Francken\Application\ReadModelRepository;
use Francken\Infrastructure\Repositories\InMemoryRepository;

class InMemoryRepositoryFeature extends RepositoryTestCase
{
    protected function createRepository() : ReadModelRepository
    {
        return new InMemoryRepository(TestReadModel::class);
    }
}
