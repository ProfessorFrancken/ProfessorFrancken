<?php

namespace Francken\Infrastructure\News;

use Francken\Application\News\NewsRepository;
use Francken\Infrastructure\News\FakeNewsRepository;
use Francken\Infrastructure\News\NewsRepositoryFromXML;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Faker\Generator;

final class NewsServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (config('francken.news.type') == 'fake') {
            $this->app->bind(NewsRepository::class, function ($app) {
                $faker = $app->make(Generator::class);

                return new NewsRepository(
                    new FakeNewsRepository($faker),
                    new FakeNewsRepository($faker),
                    new FakeNewsRepository($faker)
                );
            });
        } else {
            $this->app->bind(NewsRepository::class, function ($app) {
                $filename = config('francken.news.xml');

                return new NewsRepository(
                    new NewsRepositoryFromXml($filename),
                    new NewsRepositoryFromXml($filename),
                    new NewsRepositoryFromXml($filename)
                );
            });
        }
    }
}
