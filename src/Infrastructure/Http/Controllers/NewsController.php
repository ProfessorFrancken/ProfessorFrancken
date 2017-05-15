<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use DateInterval;
use DateTimeImmutable;
use Francken\Application\News\FakeNewsContent;
use Francken\Application\News\NewsItem;

final class NewsController
{
    private $news;
    private $faker;

    public function __construct(\Faker\Generator $faker)
    {
        $this->news = [];
        $this->faker = $faker;
    }

    public function index()
    {
        return view('pages.association.news')
            ->with('news', array_map(
                function() {
                    return $this->fakeNewsItem();
                },
                range(1, 12)
            ));
    }

    public function archive()
    {
        $faker = $this->faker;

        // Enable artificial pagination
        if (request()->has('before')) {
            $before = new DateTimeImmutable(request()->input('before', '-2 years'));
            $start = $before->sub(DateInterval::createFromDateString('2 years'));
            $end = $before;
        } elseif (request()->has('after')) {
            $after = new DateTimeImmutable(request()->input('after', 'now'));
            $start = $after;
            $end = $after->add(DateInterval::createFromDateString('2 years'));
        } else {
            $start = new DateTimeImmutable('-2 years');
            $end = new DateTimeImmutable('now');
        }

        $news = array_reverse(
            array_sort(
                array_map(
                    function($news) use ($faker, $start, $end) {
                        return new NewsItem(
                            $faker->sentence(),
                            $faker->paragraph(),
                            DateTimeImmutable::createFromMutable(
                                $faker->dateTimeBetween(
                                    $start->format('y-m-d'),
                                    $end->format('y-m-d')
                                )
                            ),
                            $faker->name(),
                            ''
                        );
                    },
                    range(0, 15)
                ),
                function (NewsItem $news) {
                    return $news->publicationDate();
                }
            )
        );

        return view('pages.association.news.archive')
            ->with('news', $news);
    }

    public function show($link)
    {
        $newsItem = $this->fakeNewsItem();

        return view('pages.association.news.item')
            ->with('newsItem', $newsItem);
    }

    private function fakeNewsItem() : NewsItem
    {
        return new NewsItem(
            $this->faker->sentence(),
            $this->faker->paragraph(),
            DateTimeImmutable::createFromMutable(
                $this->faker->dateTime()
            ),
            $this->faker->name(),
            (new FakeNewsContent($this->faker))->generate()
        );
    }
}
