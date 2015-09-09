laravel-health-checks
=====================

Allows your Laravel app to run health checks on itself to ensure various features are available, such as the database, local or remote filesystem connections, emailing, scheduled jobs, and external web services. This means you don't actually have to execute transactions in your application to make sure all external services are working.

Usage
=====

* Add to Composer:
    - Repositories: `{ "type": "vcs", "url": "git@github.com:npmweb/laravel-health-check" },`
    - Dependencies: `"npmweb/laravel-health-check": "^2.0",`
    - `composer update`
* Add service provider:

app.php

    'providers' => [
    	...
    	NpmWeb\LaravelHealthCheck\LaravelHealthCheckServiceProvider::class,
    ];
    
* Add route for the health check controller:

routes.php

    Route::resource(
        'monitor/health',
        'NpmWeb\LaravelHealthCheck\Controllers\HealthCheckController',
        ['only' => ['index','show']]
    );
    
* Configure the health checks:
    - `php artisan config:publish npmweb/laravel-health-check`
    - Edit `app/config/packages/npmweb/laravel-health-check/config.php`

Checks
======

The following health checks are available. For more information on each health check, see comments in the appropriate class under `src/NpmWeb/LaravelHealthCheck/Checks`.

* Cron: is a necessary cron job scheduled?
* Database: can the app connect to the database?
* Filesystem: is a given Laravel 5.* filesystem writable?
* Flysystem: is a Flysystem filesystem writable? (For Laravel 4, when there was not an internal Filesystem wrapper)
* Framework: sanity check: is the Laravel framework working?
* Mail: can email be sent?
* Web Service: is an external web service accessible?