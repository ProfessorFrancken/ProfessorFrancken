<?php

declare(strict_types=1);

namespace Francken\Tests\Association\News\Eloquent;

use Faker\Factory;
use Francken\Association\News\Eloquent\News;
use Francken\Association\News\Eloquent\Repository;
use Francken\Association\News\Fake\FakeNews;
use Francken\Association\News\NewsItem;
use Francken\Features\TestCase;
use Francken\Tests\Association\News\RepositoryTests;
use Illuminate\Foundation\Testing\DatabaseMigrations;

final class RepositoryTest extends TestCase
{
    use DatabaseMigrations;
    use RepositoryTests;

    protected $news;

    /** @test */
    public function it_does_not_find_unpublished_news_by_default() : void
    {
        $faker = Factory::create();
        $faker->seed(31415);
        $fake = new FakeNews($faker, 1);
        $this->setupNews($fake->all());
        $news = News::first();
        $news->archive();
        $news->save();

        $this->news = new Repository();

        $this->assertCount(0, $this->news->recent(1));

        $this->news = new Repository(true);
        $this->assertCount(1, $this->news->recent(1));
    }

    /**
     * Setup the repository with the given news
     */
    protected function setupNews(array $news = []) : void
    {
        $items = collect($news)->map(function (NewsItem $news) {
            return News::fromNewsItem($news);
        })->each(function (News $news) : void {
            $news->save();
        });

        $this->news = new Repository(true);
    }
}













// final class RepositoryTest
// {
//     private $news;

//     /**
//      * @before
//      */
//     public function setupNews()
//     {
//         $this->news = new Repository;
//     }

//     /** @test */
//     function it_searches_for_news_during_a_period()
//     {

//     }

//     /** @test */
//     function it_searches_for_news_of_some_subject()
//     {

//     }

//     /** @test */
//     function it_searches_for_news_written_by_an_author()
//     {

//     }



// }
