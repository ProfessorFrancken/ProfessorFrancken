<?php

declare(strict_types=1);

namespace Francken\Tests\Association\News;

use Faker\Factory;
use Francken\Association\News\CouldNotFindNews;
use Francken\Association\News\Fake\FakeNews;
use Francken\Association\News\NewsItem;
use League\Period\Period;

trait RepositoryTests 
{
    protected $news;

    /**
     * Setup the repository with the given news
     */
    abstract protected function setupNews(array $news = []);

    /** @test */
    function it_finds_no_recent_news_items_if_no_news_exists()
    {
        $this->setupNews([]);
        $this->assertCount(0, $this->news->recent(3));
    }

    /** @test */
    function it_finds_all_recent_news_items()
    {
        $this->setupNews($this->fakeNews(1));
        $this->assertCount(1, $this->news->recent(9));

        $this->setupNews($this->fakeNews(10));
        $this->assertCount(9, $this->news->recent(9));
    }

    /** @test */
    function it_sorts_news_when_looking_for_recent_news()
    {
        $fakeNews = $this->fakeNews(10);
        $this->setupNews($fakeNews);

        $actual = $this->news->recent(9);
        $this->assertSame(
            $actual,
            collect($actual)
                ->sortByDesc(function ($news) {
                    return $news->publicationDate()->getTimestamp();
                })
                ->values()
                ->toArray()
        );
    }

    /** @test */
    function it_finds_news_items_by_their_link()
    {
        $fakeNews = $this->fakeNews(10);

        $this->setupNews($fakeNews);

        $this->assertEquals($fakeNews[0], $this->news->byLink($fakeNews[0]->link()));
    }

    /** @test */
    function it_fails_when_looking_for_news_that_does_not_exist()
    {
        $this->setupNews([]);
        $this->expectException(CouldNotFindNews::class);

        $this->news->byLink('non-existing');
    }

    /** @test */
    function it_finds_all_news_if_no_criteria_is_given()
    {
        $fakeNews = $this->fakeNews(10);

        $this->setupNews($fakeNews);

        $this->assertNewsFound($fakeNews, $this->news->search());
    }

    /** @test */
    function it_finds_news_belonging_to_search_criteria()
    {
        $fakeNews = $this->fakeNews(10);

        $this->setupNews($fakeNews);

        $this->assertNewsFound(
            [$fakeNews[0]],
            $this->news->search(null, null, $fakeNews[0]->authorName()),
            "It did not find any news with the given author"
        );
        
        $this->assertNewsFound(
            [$fakeNews[0]],
            $this->news->search(null, $fakeNews[0]->title(), null),
            "It did not find any news with the given tile"
        );

        $publishedAt =$fakeNews[0]->publicationDate();

        // return;
        $period = new Period(
            $publishedAt,
            $publishedAt->add(new \DateInterval('PT1S'))
        );
        $this->assertNewsFound(
            [$fakeNews[0]],
            $this->news->search($period, null, null),
            "It did not find any news with in the given period"
        );
    }

    /** @test */
    function it_finds_news_in_a_given_period()
    {
        $fakeNews = $this->fakeNews(10);
        $this->setupNews($fakeNews);

        $period = new Period(
            $fakeNews[0]->publicationDate(),
            $fakeNews[3]->publicationDate()->add(new \DateInterval('PT1S'))
        );

        $this->assertNewsFound(
            [$fakeNews[0], $fakeNews[1], $fakeNews[2], $fakeNews[3]],
            $this->news->search($period, null, null),
            "It did not find any news with in the given period"
        );

        foreach ($this->news->search($period, null, null) as $news) {
            $this->assertTrue($period->contains($news->publicationDate()));
        }
    }

    /** @test */
    function it_sorts_news_when_searching_for_news()
    {
        $fakeNews = $this->fakeNews(10);
        $this->setupNews($fakeNews);

        $actual = $this->news->search();
        $this->assertSame(
            $actual,
            collect($actual)
                ->sortByDesc(function ($news) {
                    return $news->publicationDate()->getTimestamp();
                })
                ->values()
                ->toArray()
        );
    }

    private function fakeNews(int $amount = 1) : array
    {
        $faker = Factory::create();
        $faker->seed(31415);
        $fake = new FakeNews($faker, $amount);

        return collect($fake->all())->sortBy(
            function (NewsItem $news) {
                return $news->publicationDate()->getTimestamp();
            }
        )->values()->toArray();
    }

    private function assertNewsFound(array $expected, array $actual, string $reason = "Not all expected news items were found")
    {
        $contains = collect($expected)->filter(function ($news) use ($actual) {
            return collect($actual)->contains($news);
        });

        $this->assertCount(
            count($expected),
            $contains,
            $reason
        );
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
