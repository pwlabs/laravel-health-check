<?php namespace PwLabs\LaravelHealthCheck\Checks;

use Exception;
use Mail;

/**
 * Checks that Laravel can send mail. Actually sends a real message, so make
 * sure not to put in a real email address.
 *
 * Config format:
 *
 * 'checks' => [
 *   'mail' => [
 *     'email' => 'address@to.send.to',
 *     'method' => 'send' // or 'queue'
 *   ],
 *   ...
 * ]
 */
class MailHealthCheck implements HealthCheckInterface {

    protected $emailAddr;
    protected $method;

    public function __construct( array $config = null ) {
        $this->emailAddr = $config['email'];
        if( isset($config['method']) ) {
            $this->method = $config['method'];
        } else {
            $this->method = 'send';
        }
    }

    public function getName() {
        return 'mail';
    }

    public function check() {
        try {
            $method = $this->method;
            $email = $this->emailAddr;
            Mail::$method('laravel-health-check::emails.test', array(), function($message) use($email) {
                $message
                    ->from($email)
                    ->to($email)
                    ->subject('Health Check');
            });
            return true;
        } catch( \Exception $e ) {
            return false;
        }
    }

}