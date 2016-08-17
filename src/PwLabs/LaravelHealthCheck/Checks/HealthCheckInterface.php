<?php namespace PwLabs\LaravelHealthCheck\Checks;

/**
 * Interface for a health check.
 */
interface HealthCheckInterface {

    /**
     * The name the health check should be referenced by in the web service API.
     */
    public function getName();

    /**
     * Checks whatever needs to be checked. Returns true if success, false if
     * error.
     */
    public function check();

}