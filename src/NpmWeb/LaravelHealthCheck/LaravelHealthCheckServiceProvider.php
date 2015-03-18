<?php namespace NpmWeb\LaravelHealthCheck;

use Illuminate\Support\ServiceProvider;
use Log;
use NpmWeb\LaravelHealthCheck\Checks\HealthCheckManager;

class LaravelHealthCheckServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $configFilePath;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->configFilePath = __DIR__.'/../../config/config.php';
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([ $this->configFilePath => config_path('laravel-health-check.php')]);
        $this->loadViewsFrom(__DIR__.'/../../views', 'laravel-health-check');
        $this->mergeConfigFrom( $this->configFilePath, 'laravel-health-check' );

        $this->app->bind('health-checks', function($app) {
            $checkConfigs = $this->app->config->get('laravel-health-check.checks');
            $checks = [];
            foreach( $checkConfigs as $driver => $checkConfig ) {
                // echo 'foo';exit;
                $checks[] = (new HealthCheckManager($app))->driver($driver);
            }
            return $checks;
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // do nothing
    }

}
