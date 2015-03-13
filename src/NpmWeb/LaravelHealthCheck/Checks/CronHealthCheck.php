<?php namespace NpmWeb\LaravelHealthCheck\Checks;

use File;

class CronHealthCheck implements HealthCheckInterface {

    protected $cronFiles;

    public function __construct( $cronFiles ) {
        $this->cronFiles = $cronFiles;
    }

    public function getName() {
        return 'cron';
    }

    public function check() {
        $success = true;
        foreach( $this->cronFiles as $filename => $patterns ) {
            if( !$this->checkCron($filename, $patterns) ) {
                $success = false;
            }
        }
        return $success;
    }

    protected function checkCron($filename, $patterns) {
        try {
            $contents = File::get($filename);
            if( is_array($patterns) ) {
                foreach( $patterns as $pattern ) {
                    if( !$this->checkCronPattern($contents,$pattern) ) {
                        return false;
                    }
                }
                return true;
            } else {
                return $this->checkCronPattern($contents,$patterns);
            }
        } catch( Exception $e ) {
            return false;
        }
    }

    protected function checkCronPattern($contents, $pattern) {
        return false !== strpos($contents, $pattern);
    }
}