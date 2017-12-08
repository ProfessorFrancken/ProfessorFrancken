<?php

namespace Francken\Association\News;

use Faker\Generator;
use Francken\Application\News\NewsRepository;
use Francken\Infrastructure\News\CachedNewsRepository;
use Francken\Infrastructure\News\FakeNewsRepository;
use Francken\Infrastructure\News\NewsRepositoryFromXML;
use Illuminate\Cache\Repository;
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
            $router->get('association/news/{$item}', "NewsController@show");

            $router->resource('admin/association/news', 'AdminNewsController');
        });
    }
}
