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
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $objeRateLimiter = new RateLimiter();
        
        $objeRateLimiter::for('api', function (Request $request) {

            $objLimit = new Limit();

            return $objLimit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            $objRoute = new Route();

            $objRoute::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            $objRoute::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
