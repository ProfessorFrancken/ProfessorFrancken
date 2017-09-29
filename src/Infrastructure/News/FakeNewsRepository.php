<?php

declare(strict_types=1);

namespace Francken\Infrastructure\News;

use DateTimeImmutable;
use Faker\Generator;
use Francken\Application\News\Author;
use Francken\Application\News\CompiledMarkdown;
use Francken\Application\News\NewsRepository;
use Francken\Application\News\NewsItem;
use Francken\Application\News\NewsItemLink;
use Francken\Application\News\NewsItemPreview;
use Francken\Domain\News\AuthorId;
use Francken\Domain\News\NewsId;
use League\Period\Period;

final class FakeNewsRepository implements NewsRepository
{
    private $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Note that this search implementation is "fake" we only return
     * results that are in the given period and ignore the subject
     * and author criteria
     */
    public function search(Period $period = null, string $subject = null, string $author = null) : array
    {
        $amount = NewsRepository::News_Items_Per_Archive_Page;

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
            new CompiledMarkdown((new FakeNewsContent($this->faker))->generate()),
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

    public function recent(int $amount) : array
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
            range(1, $amount)
        );
    }
}
