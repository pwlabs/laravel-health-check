laravel-health-checks
=====================

Allows your Laravel app to run health checks on itself

Usage
=====

* Add to Composer:
    - Repositories: `{
                           "type": "package",
                           "package": {
                                 "name": "pwlabs/laravel-health-check",
                                 "version": "1.1.3",
                                 "source": {
                                      "url": "git://github.com/pwlabs/laravel-health-check.git",
                                      "type": "git",
                                      "reference": "larafour"
                                 },
                                 "autoload": {
                                      "psr-0" : {
                                          "PwLabs\\LaravelHealthCheck\\" : "src/"
                                      }
                                 }
                           }
                      },`
    - Dependencies: `"pwlabs/laravel-health-check": "1.1.3@larafour",`
    - `composer update`
* Add service provider:

app.php

    'providers' => array(
    	...
    	'PwLabs\LaravelHealthCheck\LaravelHealthCheckServiceProvider',
    );
    
* Add route for the health check controller:

routes.php

    Route::resource(
        'monitor/health',
        'PwLabs\LaravelHealthCheck\Controllers\HealthCheckController',
        ['only' => ['index','show']]
    );
    
* Configure the health checks:
    - `php artisan config:publish pwlabs/laravel-health-check`
    - Edit `app/config/packages/pwlabs/laravel-health-check/config.php`

For information on each health check, see comments in the appropriate class under src/PwLabs/LaravelHealthCheck/Checks.