<?php namespace NpmWeb\LaravelHealthCheck\Checks;

use Closure;
use Exception;
use League\Flysystem\FileSystem;

class FlysystemHealthCheck implements HealthCheckInterface {

    protected $flysystem;

    public function __construct( $config ) {
         \Log::debug(__METHOD__.'(' . print_r($config,true) . ')');
        $this->flysystem = $this->createFlysystem( $config );
    }

    protected function createFlysystem( $config ) {
        $adapter = $config['adapter'];
        if (is_string($adapter)) {
            $reflection = new \ReflectionClass($adapterClass);
            $inst = new Filesystem ( $reflection->newInstance( $config['config'] ) );
        } else if (is_object($adapter) && ($adapter instanceof Closure)) {
            $inst = new Filesystem( $adapter->__invoke() );
        }
        return $inst;
    }

    public function getName() {
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