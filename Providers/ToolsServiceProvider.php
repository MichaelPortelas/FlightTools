<?php

namespace Modules\FlightTools\Providers;

use App\Services\ModuleService;
use Illuminate\Support\ServiceProvider;
use Modules\FlightTools\Services\CalcTodService;
use Modules\FlightTools\Services\CalcTrlService;
use Modules\FlightTools\Services\CalcAeroService;
use Route;

/**
 * Class ToolsServiceProvider
 * @package Modules\FlightTools\Providers
 *
 * Service provider for the FlightTools module. Registers services, routes, translations, and views.
 */
class ToolsServiceProvider extends ServiceProvider
{
    /**
     * @var ModuleService
     */
    protected $moduleSvc;

    /**
     * ToolsServiceProvider constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct($app)
    {
        parent::__construct($app);
        $this->moduleSvc = app(ModuleService::class); // Initialisation de ModuleService
    }

    /**
     * Bootstrap the services provided by this provider.
     *
     * @return void
     */
    public function boot()
    {
        // $this->moduleSvc = app(ModuleService::class);
        
        $this->registerRoutes();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
    }

    /**
     * Register the services provided by this provider.
     *
     * @return void
     */
    public function register()
    { 
        // Register the service instances for CalcTodService, CalcTrlService, and CalcAeroService
        $this->app->singleton(CalcTodService::class, function ($app) {
            return new CalcTodService();
        });
        
        $this->app->singleton(CalcTrlService::class, function ($app) {
            return new CalcTrlService();
        });

        $this->app->singleton(CalcAeroService::class, function ($app) {
            return new CalcAeroService();
        });
    }

    /**
     * Register the routes for the FlightTools module.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group([
            'as'         => 'FlTools.',
            'prefix'     => 'FlightTools',
            'middleware' => ['web'],
            'namespace'  => 'Modules\FlightTools\Http\Controllers',
        ], function () {
            // Route for showing the TRL form
            Route::get('calc_trl', 'CalcTrlController@showForm')->name('calc_trl.showForm');
            // Route for calculating TRL
            Route::post('calc_trl', 'CalcTrlController@calcTrl')->name('calc_trl.calculate');

            // Route for showing the TOD form
            Route::get('calc_tod', 'CalcTodController@showForm')->name('calc_tod.showForm');
            // Route for calculating TOD
            Route::post('calc_tod', 'CalcTodController@calcTod')->name('calc_tod.calculate');

            // Route for showing the Aero form
            Route::get('calc_aero', 'CalcAeroController@showForm')->name('calc_aero.showForm');
            // Route for calculating Aero metrics
            Route::post('calc_aero', 'CalcAeroController@calculateAeroMetrics')->name('calc_aero.calculate');
            
        });
    }

    /**
     * Register the configuration files for the FlightTools module.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('FlTools.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php',
            'FlTools');
    }

    /**
     * Register the translations for the FlightTools module.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/FlightTools');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'FlTools');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'FlTools');
        }
    }

    /**
     * Register the views for the FlightTools module.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/FlightTools');
        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(
            array_filter(
                array_map(function ($path) {
                    $path = str_replace('default', setting('general.theme'), $path).'/modules/FlightTools';
                    return (file_exists($path) && is_dir($path)) ? $path : null;
                }, \Config::get('view.paths'))
            ),
            [$sourcePath]
        ), 'FlTools');
    }
    
}
