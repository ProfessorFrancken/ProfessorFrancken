<?php

namespace Francken\Association\Members;

use Francken\Association\Activities\ActivitiesSidebarComposer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\View\Factory as View;
use Route;

final class ServiceProvider extends RouteServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Francken\Association\Members\Http';

    public function boot()
    {
        parent::boot();

        $view = $this->app->make(View::class);

        $view->composer(
            'profile._sidebar',
            LoggedInAsMemberComposer::class
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
        $router->group([
            'namespace' => $this->namespace,
            'prefix' => 'profile',
            'middleware' => ['web', 'auth']
        ], function($router) {
            $router->get('/', 'ProfileController@index');

            $router->get('finances', 'FinancesController@index');
            $router->get('finances/{year}/{month}', 'FinancesController@show');
            $router->get('settings', 'SettingsController@index');
            $router->get('members', 'MembersController@index');
        });
    }
}
