<?php namespace PwLabs\LaravelHealthCheck\Checks;

use WindowsAzure\Common\ServiceException;
use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Blob\Models\CreateBlobOptions;

/**
 * Checks that the appropriate Azure Storage connection is able to connect. Uses
 * Azure PHP SDK for Storage.
 *
 * Config format:
 *
 * 'checks' => [
 *   'storage' => 'whichconnection',
 *   ...
 * ]
 */
class StorageHealthCheck implements HealthCheckInterface {

    protected $storage;

    public function __construct( $cred ) {
        $blobStorage = $this->createStorage( $cred['conn'] );
        $this->storage = $blobStorage->listBlobs( $cred['source'] );
    }

    protected function createStorage( $conn ) {
        return ServicesBuilder::getInstance()->createBlobService( $conn );
    }

    public function getName() {
        return 'storage';
    }

    public function check() {
        try {
            return null != $this->storage->getBlobs();
        } catch( \Exception $e ) {
            return false;
        }
    }

}