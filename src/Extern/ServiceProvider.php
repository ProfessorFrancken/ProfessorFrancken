<?php

declare(strict_types=1);

namespace Francken\Extern;

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
    protected $namespace = 'Francken\Extern\Http';

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
            'prefix' => 'admin/extern',
            'middleware' => ['web', 'auth']
        ], function ($router) {
            $router->get('/fact-sheet', 'FactSheetController@index');

            $unavailable = 'Francken\infrastructure\Http\Controllers\Admin\AdminController@showPageIsUnavailable';
            $router->get('companies', $unavailable);
            $router->get('events', $unavailable);
            $router->get('job-openings', $unavailable);
        });
    }
}
