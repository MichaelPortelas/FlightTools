<?php

namespace Modules\FlightTools\Providers;

use App\Services\ModuleService;
use Illuminate\Support\ServiceProvider;
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
    }

    protected function registerRoutes()
    {
        Route::group([
            'as'         => 'FlTools.',
            'prefix'     => '',
            'middleware' => ['web'],
            'namespace'  => 'Modules\FlightTools\Http\Controllers',
        ], function () {
            // Calculate TRL
            Route::get('calc_trl', 'Tools_Controller@calc_trl')->name('calc_trl');
            Route::post('calc_trl_calcTrl', 'Tools_Controller@calcTrl')->name('calc_trl.calcTrl');
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
