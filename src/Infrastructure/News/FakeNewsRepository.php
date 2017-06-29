<?php

declare(strict_types=1);

namespace Francken\Infrastructure\News;

use DateTimeImmutable;
use Faker\Generator;
use Francken\Application\News\Author;
use Francken\Application\News\FindNewsItemByLink;
use Francken\Application\News\FindNewsItemsInPeriod;
use Francken\Application\News\FindRecentNewsItems;
use Francken\Application\News\NewsItem;
use Francken\Application\News\NewsItemLink;
use Francken\Application\News\NewsItemPreview;
use Francken\Domain\News\AuthorId;
use Francken\Domain\News\NewsId;
use League\Period\Period;

final class FakeNewsRepository implements FindNewsItemsInPeriod, FindNewsItemByLink, FindRecentNewsItems
{
    private $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function inPeriod(Period $period, int $amount) : array
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
                    range(0, $amount)
                ),
                function (NewsItemLink $news) {
                    return $news->publicationDate();
                }
            )
        );
    }

    public function byLink(string $link) : NewsItem
    {
        $date = DateTimeImmutable::createFromMutable(
            $this->faker->dateTime()
        );

        return new NewsItem(
            $this->faker->sentence(),
            $this->faker->paragraph(),
            $date,
            new Author(
                $this->faker->name(),
                'https://api.adorable.io/avatars/75/' . $this->faker->randomNumber() . '.png'
            ),
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

    public function recent(int $limit) : array
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
}
