<?php namespace PwLabs\LaravelHealthCheck;

use Illuminate\Support\ServiceProvider;
use Log;
use PwLabs\LaravelHealthCheck\Checks\HealthCheckManager;

class LaravelHealthCheckServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('pwlabs/laravel-health-check');
        $this->app->bind('health-checks', function($app) {
            $checkConfigs = $this->app->config->get('laravel-health-check::checks');
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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
