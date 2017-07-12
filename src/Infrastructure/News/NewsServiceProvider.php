<?php

namespace Francken\Infrastructure\News;

use Faker\Generator;
use Francken\Application\News\NewsRepository;
use Francken\Infrastructure\News\CachedNewsRepository;
use Francken\Infrastructure\News\FakeNewsRepository;
use Francken\Infrastructure\News\NewsRepositoryFromXML;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class NewsServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (config('francken.news.type') == 'fake') {
            $this->app->bind(NewsRepository::class, function ($app) {
                $faker = $app->make(Generator::class);

                return new FakeNewsRepository($faker);
            });
        } else {
            $this->app->bind(NewsRepository::class, function ($app) {
                $filename = config('francken.news.xml');

                return new CachedNewsRepository(
                    new NewsRepositoryFromXml($filename),
                    $app->make(Repository::class)
                );
            });
        }
    }
}
