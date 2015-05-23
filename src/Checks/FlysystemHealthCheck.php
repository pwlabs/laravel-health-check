<?php namespace NpmWeb\LaravelHealthCheck\Checks;

use Closure;
use Exception;
use League\Flysystem\FileSystem;

/*
 * When using Flysystem directly, this check makes sure
 * each configured connection is working.
 */
class FlysystemHealthCheck extends AbstractHealthCheck {

    protected $flysystem;

    public function configure($config ) {
        \Log::debug(__METHOD__.'(' . print_r($config,true) . ')');
        $this->flysystem = $this->createFlysystem( $config );
    }

    protected function createFlysystem( $config ) {
        if (is_array($config)) {
            if (array_key_exists('driver',$config)) {
                $driver = array_pull($config,'driver');
            } else if (array_key_exists('adapter',$config)) {
                $driver = array_pull($config,'adapter');
            } else {
                // misconfigured
                throw new Exception('Must specify the Flystem adapter in the configuration, but configured keys are ['.implode(",", array_keys($config)). ']');
            }
        } else if (is_string($config)) {
            // using a config from Laravel's filesystem
            $fsConfig = \Config::get('filesystems.disks');
            \Log::debug(__METHOD__.':: got filesystem config: '.print_r($fsConfig,true));
            $driver = array_pull($fsConfig[$config],'driver');
            $config = $fsConfig;
        }

        $adapterClass = $this->getAdapterForDriver($driver);
        \Log::debug(__METHOD__.':: now instantiating a Flysystem for '.$driver.'with adapter '.$adapterClass);

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

    /*
     * maps the short driver name to the full class for Flysystem Adapter
     */
    public function getAdapterForDriver($driver) {
        switch($driver) {
            case 'ftp':
                return 'League\Flysystem\Adapter\Ftp';
            case 'sftp':
                return 'League\Flysystem\Sftp\SftpAdapter';
            case 'local':
                return 'League\Flysystem\Adapter\Local';
            case 'rackspace':
                return 'League\Flysystem\Rackspace\RackspaceAdapter';
            default:
                throw new Exception('Driver not supported: '.$driver);
        }

    }

}