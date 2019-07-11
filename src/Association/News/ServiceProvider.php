<?php

declare(strict_types=1);

namespace Francken\Association\News;

use Faker\Generator;
use Francken\Association\News\Cache\Repository as CachedNewsRepository;
use Francken\Association\News\Eloquent\Repository as EloquentNewsRepository;
use Francken\Association\News\Fake\FakeNews;
use Francken\Association\News\InMemory\Repository as InMemoryNewsRepository;
use Francken\Association\News\Xml\WordpressNewsIterator;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    public function register() : void
    {
        if (config('francken.news.type') == 'fake') {
            $this->app->bind(Repository::class, function ($app) {
                $faker = $app->make(Generator::class);
                $faker->seed(31415);
                $fakeNews = new FakeNews($faker, 100);
                return new InMemoryNewsRepository($fakeNews->all());
            });
        } elseif (config('francken.news.type') == 'eloquent') {
            $this->app->bind(Repository::class, function ($app) {
                return new CachedNewsRepository(
                    $app->make(EloquentNewsRepository::class),
                    $app->make(CacheRepository::class)
                );
            });

            $this->app->when(\Francken\Association\News\Http\AdminNewsController::class)
                ->needs(Repository::class)
                ->give(function () {
                    // Show unpublished news
                    return new EloquentNewsRepository(true);
                });
        } else {
            $this->app->bind(Repository::class, function ($app) {
                $filename = config('francken.news.xml');
                $authors = config('francken.news.authors');

                return new CachedNewsRepository(
                    new InMemoryNewsRepository(
                        iterator_to_array(
                            new WordpressNewsIterator(
                                $filename,
                                $authors
                            )
                        )
                    ),
                    $app->make(CacheRepository::class)
                );
            });
        }
    }
}
