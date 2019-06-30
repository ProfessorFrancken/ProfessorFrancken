<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use Francken\Application\Career\AcademicYear;
use Francken\Infrastructure\Http\Controllers\MainContentController;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Francken\Infrastructure\Http\Controllers';

    /**
     * Define the routes for the application.
     */
    public function map(Router $router) : void
    {
        $this->mapWebRoutes($router);
        $this->mapApiRoutes($router);

        $router->bind(
            'academic_year',
            function (string $year) : AcademicYear {
                return AcademicYear::fromString($year);
            }
        );
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(Router $router) : void
    {
        $router->middleware('web')
             ->group(base_path('routes/web.php'));

        $router->middleware('web')
             ->group(base_path('routes/admin.php'));

        $router->group(['middleware' => ['web', 'bindings']], function () use ($router) : void {
            $router->fallback([MainContentController::class, 'page']);
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(Router $router) : void
    {
        $router->middleware('api')
             ->group(base_path('routes/api.php'));
    }
}
