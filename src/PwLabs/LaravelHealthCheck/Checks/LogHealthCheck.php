<?php namespace PwLabs\LaravelHealthCheck\Checks;

use Monolog;
use Monolog\Logger;

/**
 * Checks that the appropriate Logentries connection is able to connect. Uses
 * Monolog for interfacing.
 *
 * Config format:
 *
 * 'checks' => [
 *   'log' => 'whichconnection',
 *   ...
 * ]
 */
class LogHealthCheck implements HealthCheckInterface {

    protected $log;

    public function __construct( $conn ) {
        $this->log = new Monolog\Handler\LogEntriesHandler( $conn );
    }

    public function getName() {
        return 'log';
    }

    public function check() {
        try {
            \Log::getMonolog()->pushHandler( $this->log );
            return null != \Log::info('LogCheck');
        } catch( \Exception $e ) {
            return false;
        }
    }

}