<?php

namespace Francken\Association\News;

use Faker\Generator;
use Francken\Association\News\Repository;
use Francken\Association\News\Cache\CachedNewsRepository;
use Francken\Association\News\Fake\FakeNews;
use Francken\Association\News\InMemory\Repository as InMemoryNewsRepository;
use Francken\Association\News\Eloquent\Repository as EloquentNewsRepository;
use Francken\Infrastructure\News\NewsRepositoryFromXML;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

final class ServiceProvider extends RouteServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Francken\Association\News\Http';

    public function register()
    {
        if (config('francken.news.type') == 'fake') {
            $this->app->bind(Repository::class, function ($app) {
                $faker = $app->make(Generator::class);
                $faker->seed(31415);
                $fakeNews = new FakeNews($faker, 10);
                return new InMemoryNewsRepository($fakeNews->all());
            });
        } elseif (config('francken.news.type') == 'eloquent') {
            $this->app->bind(Repository::class, function ($app) {
                return $app->make(EloquentNewsRepository::class);
            });
        } else {
            $this->app->bind(Repository::class, function ($app) {
                $filename = config('francken.news.xml');

                return new CachedNewsRepository(
                    new NewsRepositoryFromXml($filename),
                    $app->make(CacheRepository::class)
                );
            });
        }
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            $router->get('association/news', "NewsController@index");
            $router->get('association/news/archive', "NewsController@archive");
            $router->get('association/news/{item}', "NewsController@show");

            $router->resource('admin/association/news', 'AdminNewsController');
        });
    }
}
