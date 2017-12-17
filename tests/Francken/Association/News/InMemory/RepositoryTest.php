<?php

declare(strict_types=1);

namespace Francken\Tests\Association\News\InMemory;

use PHPUnit_Framework_TestCase as TestCase;
use Francken\Association\News\InMemory\Repository;
use Francken\Tests\Association\News\RepositoryTests;

final class RepositoryTest extends TestCase
{
    use RepositoryTests;

    /**
     * Setup the repository with the given news
     */
    private function setupNews(array $news = [])
    {
        $this->news = new Repository($news);
    }
}
