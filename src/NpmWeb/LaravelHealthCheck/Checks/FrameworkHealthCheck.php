<?php namespace NpmWeb\LaravelHealthCheck\Checks;

class FrameworkHealthCheck implements HealthCheckInterface {

    public function getName() {
        return 'framework';
    }

    public function check() {
        return true; // if we get here, the framework is up
    }

}