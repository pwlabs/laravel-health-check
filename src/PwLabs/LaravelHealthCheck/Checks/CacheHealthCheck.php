<?php namespace PwLabs\LaravelHealthCheck\Checks;

use Cache;

/**
 * Checks that the Laravel default cache connection can connect. No config
 * needed.
 */
class CacheHealthCheck implements HealthCheckInterface {

    public function getName() {
        return 'cache';
    }

    public function check() {
        try {
            Cache::put('healthcheck', 1, 1);
            return false != Cache::get('healthcheck');
        } catch( \Exception $e ) {
            return false;
        }
    }

}