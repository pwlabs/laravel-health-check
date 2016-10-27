<?php namespace PwLabs\LaravelHealthCheck\Checks;

use Illuminate\Support\Manager;

class HealthCheckManager extends Manager {

    static $packageName = 'laravel-health-check';

    /**
     * Create a new driver instance.
     *
     * @param  string  $driver
     * @return mixed
     */
    protected function createDriver($driver)
    {
        $reference = parent::createDriver($driver);

        // any other setup needed

        return $reference;
    }

    /**
     * Create an instance of the cron driver.
     *
     * @return \PwLabs\LaravelHealthCheck\Checks\HealthCheckInterface
     */
    public function createCronDriver()
    {
        return new CronHealthCheck($this->getCheckConfig('cron'));
    }

    /**
     * Create an instance of the database driver.
     *
     * @return \PwLabs\LaravelHealthCheck\Checks\HealthCheckInterface
     */
    public function createDatabaseDriver()
    {
        return new DatabaseHealthCheck;
    }

    /**
     * Create an instance of the flysystem driver.
     *
     * @return \PwLabs\LaravelHealthCheck\Checks\HealthCheckInterface
     */
    public function createFlysystemDriver()
    {
        return new FlysystemHealthCheck($this->getCheckConfig('flysystem'));
    }

    /**
     * Create an instance of the azure storage driver.
     *
     * @return \PwLabs\LaravelHealthCheck\Checks\HealthCheckInterface
     */
    public function createStorageDriver()
    {
        return new StorageHealthCheck($this->getCheckConfig('storage'));
    }

    /**
     * Create an instance of the monolog driver.
     *
     * @return \PwLabs\LaravelHealthCheck\Checks\HealthCheckInterface
     */
    public function createLogDriver()
    {
        return new LogHealthCheck($this->getCheckConfig('log'));
    }

    /**
     * Create an instance of the cache driver.
     *
     * @return \PwLabs\LaravelHealthCheck\Checks\HealthCheckInterface
     */
    public function createCacheDriver()
    {
        return new CacheHealthCheck;
    }

    /**
     * Create an instance of the framework driver.
     *
     * @return \PwLabs\LaravelHealthCheck\Checks\HealthCheckInterface
     */
    public function createFrameworkDriver()
    {
        return new FrameworkHealthCheck;
    }

    /**
     * Create an instance of the mail queue driver.
     *
     * @return \PwLabs\LaravelHealthCheck\Checks\HealthCheckInterface
     */
    public function createMailDriver()
    {
        return new MailHealthCheck($this->getCheckConfig('mail'));
    }

    protected function getCheckConfig($checkName) {
        $checkConfigs = $this->app->config->get('laravel-health-check::checks');
        return $checkConfigs[$checkName];
    }

    /**
     * Get the default authentication driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        $driver = $this->app['config']->get(self::$packageName.'::driver');
        return $driver;
    }

    /**
     * Set the default authentication driver name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']->set(self::$packageName.'::driver', $name);
    }

}
