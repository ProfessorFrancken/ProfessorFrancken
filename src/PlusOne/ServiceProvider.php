<?php

namespace Francken\PlusOne;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Routing\Router;

final class ServiceProvider extends RouteServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Francken\PlusOne\Http';

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
            'middleware' => ['api'],
            'prefix' => 'api'
        ], function ($router) {
            $router->post('authenticate', 'AuthenticationController@post');

            $router->group(['middleware' => 'plus-one'], function ($router) {
                $router->get('products', 'ProductsController@index');
                $router->get('members', 'MembersController@index');
                $router->get('committees', 'CommitteesController@index');
                $router->get('boards', 'BoardsController@index');

                $router->post('orders', 'OrdersController@post');
            });
        });
    }
}
