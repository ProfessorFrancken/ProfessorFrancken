<?php

declare(strict_types=1);

namespace Francken\Application\News;

use Francken\Domain\News\NewsId;
use Francken\Domain\News\AuthorId;
use Faker\Generator;
use League\Period\Period;
use DateTimeImmutable;

final class NewsRepository
{
    private $faker;

    const News_Items_Per_Page = 12;
    const News_Items_Per_Archive_Page = 15;

    public function __construct(
        Generator $faker,
    ) {
        $this->faker = $faker;
    }

    public function recent(int $limit = self::News_Items_Per_Page) :  array
    {
        return array_map(
            function() : NewsItemPreview {
                return new NewsItemPreview(
                    $this->faker->sentence(),
                    $this->faker->paragraph(),
                    DateTimeImmutable::createFromMutable(
                        $this->faker->dateTime()
                    ),
                    $this->faker->name()
                );
            },
            range(1, $limit)
        );
    }

    public function findInPeriod(Period $period) : array
    {
        return array_reverse(
            array_sort(
                array_map(
                    function($news) use ($period) : NewsItemLink {
                        return new NewsItemLink(
                            $this->faker->sentence(),
                            DateTimeImmutable::createFromMutable(
                                $this->faker->dateTimeBetween(
                                    $period->getStartDate()->format('y-m-d'),
                                    $period->getEndDate()->format('y-m-d')
                                )
                            )
                        );
                    },
                    range(0, self::News_Items_Per_Archive_Page)
                ),
                function (NewsItemLink $news) {
                    return $news->publicationDate();
                }
            )
        );
    }

    public function findByLink(string $link) : NewsItem
    {
        return $this->fakeNewsItem();
    }

    private function fakeNewsItem() : NewsItem
    {
        $date = DateTimeImmutable::createFromMutable(
            $this->faker->dateTime()
        );

        return new NewsItem(
            $this->faker->sentence(),
            $this->faker->paragraph(),
            $date,
            $this->faker->name(),
            (new FakeNewsContent($this->faker))->generate(),
            array_map(
                function() {
                    return new NewsItemLink(
                        $this->faker->sentence(),
                        DateTimeImmutable::createFromMutable(
                            $this->faker->dateTimeThisYear()
                        )
                    );
                }, range(1, $this->faker->numberBetween(2, 5))
            ),
            new NewsItemLink(
                $this->faker->sentence(),
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween(
                        $date->sub(new \DateInterval('P1M'))->format('y-m-d'),
                        $date->format('y-m-d')
                    )
                )
            ),
            new NewsItemLink(
                $this->faker->sentence(),
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween(
                        $date->format('y-m-d'),
                        $date->add(new \DateInterval('P1M'))->format('y-m-d')
                    )
                )
            )
        );
    }
}
