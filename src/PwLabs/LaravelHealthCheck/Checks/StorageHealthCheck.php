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

    public function __construct( $conn ) {
        $this->storage = $this->createStorage( $conn );
    }

    protected function createStorage( $conn ) {
        return ServicesBuilder::getInstance()->createBlobService( $conn );
    }

    public function getName() {
        return 'storage';
    }

    public function check() {
        try {
            $blob_list = $this->storage->listBlobs("banners");
            return null != $blob_list->getBlobs();
        } catch( \Exception $e ) {
            return false;
        }
    }

}