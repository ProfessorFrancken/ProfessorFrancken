<?php

declare(strict_types=1);

namespace Francken\Tests\Association\News\Eloquent;

use Francken\Association\News\Eloquent\Repository;
use Francken\Association\News\Eloquent\News;
use Francken\Features\TestCase;
use Francken\Tests\Association\News\RepositoryTests;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Francken\Association\News\NewsItem;

final class RepositoryTest extends TestCase
{
    use DatabaseMigrations;
    use RepositoryTests;

    protected $news;

    /**
     * Setup the repository with the given news
     */
    protected function setupNews(array $news = [])
    {
        $items = collect($news)->map(function (NewsItem $news) {
            return News::fromNewsItem($news);
        })->each(function (News $news) {
            $news->save();
        });

        $this->news = new Repository($news);
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