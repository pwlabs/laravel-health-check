<?php namespace NpmWeb\LaravelHealthCheck\Checks;

use Exception;
use Mail;

class MailHealthCheck implements HealthCheckInterface {

    protected $method;

    public function __construct( $method = 'send' ) {
        $this->method = $method;
    }

    public function getName() {
        return 'mail-queue';
    }

    public function check() {
        try {
            $method = $this->method;
            Mail::$method('laravel-health-check::emails.test', array(), function($message) {
                $message
                    ->from('npmunplug@gmail.com')
                    ->to('josh.justice@northpoint.org')
                    ->subject('Health Check');
            });
            return true;
        } catch( Exception $e ) {
            return false;
        }
    }

}