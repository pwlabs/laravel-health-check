<?php namespace NpmWeb\LaravelHealthCheck\Checks;

use Closure;
use Exception;
use League\Flysystem\FileSystem;

/*
 * When using Flysystem directly, this check makes sure
 * each configured connection is working.
 */
class FlysystemHealthCheck implements HealthCheckInterface {

    protected $flysystem;

    public function __construct( $config ) {
        \Log::debug(__METHOD__.'(' . print_r($config,true) . ')');
        $this->flysystem = $this->createFlysystem( $config );
    }

    protected function createFlysystem( $config ) {
        if (is_array($config)) {
            if (array_key_exists('driver',$config)) {
                $adapterClass = array_pull($config,'driver');
            } else if (array_key_exists('adapter',$config)) {
                $adapterClass = array_pull($config,'adapter');
            } else {
                // misconfigured
                throw new Exception('Must specify the Flystem adapter in the configuration, but configured keys are ['.implode(",", array_keys($config)). ']');
            }
        } else if (is_string($config)) {
            // using a config from Laravel's filesystem
            $config = \Config::get('filesystem.disks.' . $config);
            $adapterClass = array_pull($config,'driver');
        }

        \Log::debug(__METHOD__.':: now instantiating a Flysystem with adapter '.$adapterClass);

        $reflection = new \ReflectionClass($adapterClass);
        $inst = new Filesystem ( $reflection->newInstance( $config ) );
        return $inst;
    }

    public function getType() {
        return 'flysystem';
    }

    public function check() {
        try {
            $files = $this->flysystem->listContents();
            \Log::debug(__METHOD__.':: Got these files: '.print_r($files,true));
            return ( $files !== false && !empty($files));
        } catch( Exception $e ) {
            return false;
        }
    }

}