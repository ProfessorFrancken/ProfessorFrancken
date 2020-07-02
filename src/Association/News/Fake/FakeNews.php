<?php

declare(strict_types=1);

namespace Francken\Association\News\Fake;

use DateTimeImmutable;
use Faker\Generator;

use Francken\Association\News\Author;
use Francken\Association\News\CompiledMarkdown;
use Francken\Association\News\NewsItem;

final class FakeNews
{
    private $faker;
    private $news;

    public function __construct(Generator $faker, int $amount)
    {
        $this->faker = $faker;
        $this->news = $this->generateNews($amount);
    }

    public function all() : array
    {
        return $this->news;
    }

    private function generateNews(int $amount) : array
    {
        // First create a set of titles with associated publication dates
        // we use this to set the next and previous news items
        $publishedNews = collect(range(1, $amount))
            ->map(function () {
                return [
                    'title' => $this->faker->sentence(),
                    'published_at' => DateTimeImmutable::createFromMutable(
                        $this->faker->dateTime()
                    )
                ];
            })
            ->sortByDesc(function ($news) {
                return $news['published_at']->getTimestamp();
            })
            ->values();

        return $publishedNews->map(function ($news, int $key) use ($publishedNews) {
            $content = (new FakeNewsContent($this->faker))->generate();

            return new NewsItem(
                $news['title'],
                $this->faker->paragraph(),
                new Author(
                    $this->faker->name(),
                    'https://api.adorable.io/avatars/75/' . $this->faker->randomNumber() . '.png'
                ),
                CompiledMarkdown::withSource(
                    $content,
                    $content
                ),
                $news['published_at']
            );
        })->toArray();
    }
}
