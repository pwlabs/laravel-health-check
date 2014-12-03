<?php namespace NpmWeb\LaravelHealthCheck\Checks;

use Exception;
use GrahamCampbell\Flysystem\Facades\Flysystem;

class FlysystemHealthCheck implements HealthCheckInterface {

    protected $flysystem;

    public function __construct( $conn ) {
        $this->flysystem = $this->createFlysystem( $conn );
    }

    protected function createFlysystem( $conn ) {
        return Flysystem::connection( $conn );
    }

    public function getName() {
        return 'flysystem';
    }

    public function check() {
        try {
            return null != $this->flysystem->listContents();
        } catch( Exception $e ) {
            return false;
        }
    }

}