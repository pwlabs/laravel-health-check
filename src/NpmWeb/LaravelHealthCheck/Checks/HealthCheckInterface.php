<?php namespace NpmWeb\LaravelHealthCheck\Checks;

interface HealthCheckInterface {

    public function getName();

    public function check();

}