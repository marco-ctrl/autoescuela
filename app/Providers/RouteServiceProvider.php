<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->us_codigo ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/apiManager.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web', )
                ->prefix('docente')
                ->group(base_path('routes/docente.php'));

            Route::middleware('web', )
                ->prefix('manager')
                ->group(base_path('routes/manager.php'));

            Route::middleware('web', )
                ->prefix('estudiante')
                ->group(base_path('routes/estudiante.php'));
        });

        /**
         * ====================================================
         *   CARGA DINÁMICA de todas las ROUTES establecidas
         * para cada Entidad comprendida en cada Bundle Context
         * ====================================================
         */
        $boundedContexts = ['admin', 'manager', 'app', 'landing', 'docente'];
        foreach ($boundedContexts as $boundedContext) {
            if (is_dir(base_path("src/$boundedContext"))) {
                foreach (File::allFiles(base_path("src/$boundedContext/**/infrastructure/routes")) as $routeFile) {
                    $type = explode(".", $routeFile->getBasename())[0];
                    Route::prefix($type)
                        ->middleware($type)
                        ->group($routeFile->getRealPath());
                }
            }
        }
        // ====================================================
    }
}
