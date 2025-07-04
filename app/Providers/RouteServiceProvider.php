<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
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
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web', 'auth')
                    ->prefix('configuracion')
                    ->name('configuracion.')
                    ->group(base_path('routes/configuracion.php'));

            Route::middleware('web', 'auth')
                    ->prefix('facturacion')
                    ->name('facturacion.')
                    ->group(base_path('routes/facturacion.php'));

            Route::middleware('web', 'auth')
                    ->prefix('diligencia')
                    ->name('diligencia.')
                    ->group(base_path('routes/diligencia.php'));

            Route::middleware('web', 'auth')
                    ->prefix('financiera')
                    ->name('financiera.')
                    ->group(base_path('routes/financiera.php'));

            Route::middleware('web', 'auth')
                    ->prefix('humana')
                    ->name('humana.')
                    ->group(base_path('routes/humana.php'));
        });
    }
}
