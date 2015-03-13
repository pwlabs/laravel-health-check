<?php namespace NpmWeb\LaravelHealthCheck\Checks;

use DB;

/**
 * Checks that the Laravel default database connection can connect. No config
 * needed.
 */
class DatabaseHealthCheck implements HealthCheckInterface {

    public function getName() {
        return 'database';
    }

    public function check() {
        try {
            return false != DB::select('SELECT 1');
        } catch( Exception $e ) {
            return false;
        }
    }

}