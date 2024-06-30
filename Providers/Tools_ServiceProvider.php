<?php

namespace Modules\FlightTools\Providers;

use App\Services\ModuleService;
use Illuminate\Support\ServiceProvider;
use Modules\FlightTools\Services\CalcTodService;
use Modules\FlightTools\Services\CalcTrlService;
use Route;

/**
 * Register the routes required for your module here
 */
class Tools_ServiceProvider extends ServiceProvider
{
    protected $moduleSvc;

    public function boot()
    {
        $this->moduleSvc = app(ModuleService::class);

        $this->registerRoutes();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
    }

    public function register()
    { 
        $this->app->singleton(CalcTodService::class, function ($app) {
            return new CalcTodService();
        });
        
        $this->app->singleton(CalcTrlService::class, function ($app) {
            return new CalcTrlService();
        });
    }

    protected function registerRoutes()
    {
        Route::group([
            'as'         => 'FlTools.',
            'prefix'     => 'FlightTools',
            'middleware' => ['web'],
            'namespace'  => 'Modules\FlightTools\Http\Controllers',
        ], function () {
            // Calculate TRL
            Route::get('calc_trl', 'CalcTrlController@showForm')->name('calc_trl.showForm');
            Route::post('calc_trl', 'CalcTrlController@calcTrl')->name('calc_trl.calculate');
            // Calculate TOD
            Route::get('calc_tod', 'CalcTodController@showForm')->name('calc_tod.showForm');
            Route::post('calc_tod', 'CalcTodController@calcTod')->name('calc_tod.calculate');
            // Calculate Aero
            // Route::get('calc_aero', 'CalcAeroController@showForm')->name('calc_aero.showForm');
            // Route::post('calc_aero', 'CalcAeroController@calcAero')->name('calc_aero.calculate');
            
        });
    }

    protected function registerConfig()
    {
        $this->publishes([__DIR__ . '/../Config/config.php' => config_path('FlTools.php'),], 'config');
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'FlTools');
    }

    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/FlightTools');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'FlTools');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'FlTools');
        }
    }

    public function registerViews()
    {
        $viewPath = resource_path('views/modules/FlightTools');
        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([$sourcePath => $viewPath,], 'views');

        $this->loadViewsFrom(array_merge(array_filter(array_map(function ($path) {
            $path = str_replace('default', setting('general.theme'), $path).'/modules/FlightTools'; 
            return (file_exists($path) && is_dir($path)) ? $path : null;
        }, \Config::get('view.paths'))), [$sourcePath]), 'FlTools');
    }
    
}
