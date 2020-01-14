<?php

namespace Innoflash\Zoomconnect;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Innoflash\Zoomconnect\SMSModes\XMLMode;
use Innoflash\Zoomconnect\SMSModes\JSONMode;
use Innoflash\Zoomconnect\ZoomconnectFacade;
use Innoflash\Zoomconnect\Contracts\SMSModeContract;
use Innoflash\Zoomconnect\Helpers\ZoomConnectConfig;

class ZoomconnectServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/zoomconnect.php', 'zoomconnect');
        $this->publishThings();
        $this->register();
        // $this->loadViewsFrom(__DIR__.'/resources/views', 'zoomconnect');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->registerRoutes();

        $this->app->singleton(SMSModeContract::class, function ($app) {
            if (ZoomConnectConfig::getSMSMethod() === 'json') return new JSONMode();
            return new XMLMode();
        });
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        });
    }

    /**
     * Get the Blogg route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'namespace'  => "Innoflash\Zoomconnect\Http\Controllers",
            'middleware' => 'api',
            'prefix'     => 'api'
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register facade
        $this->app->singleton('zoomconnect', function () {
            return new ZoomconnectFacade;
        });
    }

    public function publishThings()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/zoomconnect.php' => config_path('zoomconnect.php'),
            ], 'zoomconnect-config');
        }
    }
}
