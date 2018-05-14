<?php

namespace Francken\Association\Activities;

use Francken\Association\Activities\ActivitiesSidebarComposer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\View\Factory as View;

final class ServiceProvider extends RouteServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Francken\Association\Activities\Http';

    public function boot()
    {
        parent::boot();

        $view = $this->app->make(View::class);

        $view->composer(
            'association.activities.index',
            ActivitiesSidebarComposer::class
        );

        $this->app->bind(
            ActivitiesRepository::class,
            function ($app) {
                return new ActivitiesRepository(
                    fopen(storage_path('app/calendar.ics'),'r')
                );
            }
        );
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        // $router->group([
        //     'namespace' => $this->namespace,
        //     'middleware' => ['api'],
        //     'prefix' => 'api/sympcie'
        // ], function ($router) {
        //     $router->post('registrations', 'RegistrationController@post');
        // });
    }
}
