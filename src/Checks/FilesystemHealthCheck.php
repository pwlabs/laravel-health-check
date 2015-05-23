<?php namespace NpmWeb\LaravelHealthCheck\Checks;

use Exception;
use Storage;

/**
 * configuration is the disk name(s) configured in filesystems config file
 */
class FilesystemHealthCheck extends AbstractHealthCheck {

    public function configure( $config ) {
        parent::configure($config);
        $this->setInstanceName( $config );
    }

    public function getType() {
        return 'filesystem';
    }

    public function check() {
        try {
            $files = Storage::disk( $this->getInstanceName() )->files();
             \Log::debug(__METHOD__.':: Got these files: '.print_r($files,true));
            return ( $files !== false && !empty($files));
        } catch( Exception $e ) {
            return false;
        }
    }

}