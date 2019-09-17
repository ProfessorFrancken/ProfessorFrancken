<?php

declare(strict_types=1);

namespace Francken\Tests\Association\News\InMemory;

use Francken\Association\News\InMemory\Repository;
use Francken\Tests\Association\News\RepositoryTests;
use PHPUnit\Framework\TestCase as TestCase;

final class RepositoryTest extends TestCase
{
    use RepositoryTests;

    /**
     * Setup the repository with the given news
     */
    private function setupNews(array $news = []) : void
    {
        $this->news = new Repository($news);
    }
}
