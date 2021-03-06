<?php

declare(strict_types=1);

namespace Francken\Association\News\Fake;

use DateTimeImmutable;
use Faker\Generator;
use Francken\Association\News\CompiledMarkdown;
use Francken\Association\News\News;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

final class FakeNews
{
    private Generator $faker;

    private Collection $news;

    public function __construct(Generator $faker, int $amount)
    {
        $this->faker = $faker;
        $this->news = $this->generateNews($amount);
    }

    public function all() : Collection
    {
        return $this->news;
    }

    private function generateNews(int $amount) : Collection
    {
        // First create a set of titles with associated publication dates
        // we use this to set the next and previous news items
        $publishedNews = collect(range(1, $amount))
            ->map(fn () : array => [
                'title' => $this->faker->sentence(),
                'published_at' => DateTimeImmutable::createFromMutable(
                    $this->faker->dateTime()
                )
            ])
            ->sortByDesc(fn ($news) => $news['published_at']->getTimestamp())
            ->values();

        return $publishedNews->map(function ($news) : News {
            $content = (new FakeNewsContent($this->faker))->generate();
            $markdown = CompiledMarkdown::withSource(
                $content,
                $content
            );

            return new News([
                'title' => $news['title'],
                'slug' => Str::slug($news['title']),
                'exerpt' => $this->faker->paragraph(),
                'author_name' => $this->faker->name(),
                'author_photo' => 'https://api.adorable.io/avatars/75/' . $this->faker->randomNumber() . '.png',
                'source_contents' => $markdown->originalMarkdown(),
                'compiled_contents' => $markdown->compiledContent(),
                'published_at' => $news['published_at'],
                'related_news_items' => [],
            ]);
        });
    }
}
