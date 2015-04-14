<?php namespace NpmWeb\LaravelHealthCheck\Checks;

use Illuminate\Support\Manager;

class HealthCheckManager extends Manager {

    static $packageName = 'laravel-health-check';
    private $config;

    /**
     * Create a new manager instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);
        $this->config = config( self::$packageName . '.checks');
    }

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
     * Create an instance of the database driver.
     *
     * @return \NpmWeb\LaravelHealthCheck\Checks\HealthCheckInterface
     */
    public function createDatabaseDriver()
    {
        return new DatabaseHealthCheck;
    }

    /**
     * Create an instance of the flysystem driver.
     *
     * @return \NpmWeb\LaravelHealthCheck\Checks\HealthCheckInterface
     */
    public function createFlysystemDriver()
    {
        return new FlysystemHealthCheck($this->getCheckConfig('flysystem'));
    }

    /**
     * Create an instance of the framework driver.
     *
     * @return \NpmWeb\LaravelHealthCheck\Checks\HealthCheckInterface
     */
    public function createFrameworkDriver()
    {
        return new FrameworkHealthCheck;
    }

    /**
     * Create an instance of the mail queue driver.
     *
     * @return \NpmWeb\LaravelHealthCheck\Checks\HealthCheckInterface
     */
    public function createMailDriver()
    {
        return new MailHealthCheck($this->getCheckConfig('mail'));
    }

    protected function getCheckConfig($checkName) {
        $checkConfig = $this->config[ $checkName ];
        return $checkConfig;
    }

    /**
     * Get the default authentication driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        $driver = $this->config[self::$packageName.'::driver'];
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
