<?php

namespace Modules\FlightTools\Providers;

use App\Contracts\Modules\ServiceProvider;

/**
 * @package $NAMESPACE$
 */
class AppServiceProvider extends ServiceProvider
{
    private $moduleSvc;

    protected $defer = false;

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->moduleSvc = app('App\Services\ModuleService');

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();

        $this->registerLinks();

        // Uncomment this if you have migrations
        // $this->loadMigrationsFrom(__DIR__ . '/../$MIGRATIONS_PATH$');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }

    /**
     * Add module links here
     */
    public function registerLinks(): void
    {
        // Show this link if logged in
        // $this->moduleSvc->addFrontendLink('FlightTools', '/flighttools', '', $logged_in=true);

        // Admin links:
        $this->moduleSvc->addAdminLink('FlightTools', '/admin/flighttools');
    }

    /**
     * Register config.
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('flighttools.php'),
        ], 'flighttools');

        $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'flighttools');
    }

    /**
     * Register views.
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/flighttools');
        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([$sourcePath => $viewPath],'views');

        $this->loadViewsFrom(array_merge(array_filter(array_map(function ($path) {
            $path = str_replace('default', setting('general.theme'), $path);
            // Check if the directory exists before adding it
            if (file_exists($path.'/modules/flighttools') && is_dir($path.'/modules/flighttools'))
              return $path.'/modules/flighttools';

            return null;
        }, \Config::get('view.paths'))), [$sourcePath]), 'flighttools');
    }

    /**
     * Register translations.
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/flighttools');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'flighttools');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'flighttools');
        }
    }
}
