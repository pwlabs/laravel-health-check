<?php namespace NpmWeb\LaravelHealthCheck\Checks;

/**
 * Checks that Laravel is running. Shouldn't ever be needed, because the list
 * of health checks won't be returned without the framework, but a nice sanity
 * test.
 */
class FrameworkHealthCheck implements HealthCheckInterface {

    public function getName() {
        return 'framework';
    }

    public function check() {
        return true; // if we get here, the framework is up
    }

}