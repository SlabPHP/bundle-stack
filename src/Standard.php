<?php
/**
 * Slab Bundle Configuration class
 *
 * To add a Slab site/bundle you should create one of these as \YourNamespace\Configuration in the base of your
 * namespace so Slab can communicate with your package.
 *
 * Overload the database/session/etc. returning functions to override the default Slab components.
 *
 * The purpose of this type of architecture is to allow Slab bundles to be built against standard php application
 * skeletons, a la https://github.com/php-pds/skeleton
 *
 * @package Slab
 * @subpackage Bundle
 * @author Eric
 */
namespace Slab\Bundle;

abstract class Standard implements \Slab\Components\BundleInterface
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $sourceDirectory;

    /**
     * @var string
     */
    private $configDirectory;

    /**
     * @var string
     */
    private $viewDirectory;

    /**
     * @var string
     */
    private $packageDirectory;

    /**
     * @var string
     */
    private $resourceDirectory;

    /**
     * StandardConfiguration constructor.
     */
    public function __construct()
    {
        $this->namespace = dirname(get_called_class());

        //This class expects to be at the root namespace
        $this->sourceDirectory = $this->getCurrentWorkingDirectory();

        $this->packageDirectory = dirname($this->sourceDirectory);

        $this->viewDirectory = $this->sourceDirectory . DIRECTORY_SEPARATOR . 'views';

        $this->configDirectory = $this->packageDirectory . DIRECTORY_SEPARATOR . 'config';

        $this->resourceDirectory = $this->packageDirectory . DIRECTORY_SEPARATOR . 'resources';
    }

    /**
     * Implement and return __DIR__ from your class
     *
     * @return mixed
     */
    abstract protected function getCurrentWorkingDirectory();

    /**
     * @return string
     */
    public function getSourceDirectory()
    {
        return $this->sourceDirectory;
    }

    /**
     * @return string
     */
    public function getPackageDirectory()
    {
        return $this->packageDirectory;
    }

    /**
     * @return string
     */
    public function getViewDirectory()
    {
        return $this->viewDirectory;
    }

    /**
     * @return string
     */
    public function getConfigDirectory()
    {
        return $this->configDirectory;
    }

    /**
     * @return string
     */
    public function getResourceDirectory()
    {
        return $this->resourceDirectory;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return null
     */
    public function getLogger()
    {
        return null;
    }

    /**
     * @return null|\Slab\Components\InputManagerInterface
     */
    public function getInputManager()
    {
        return null;
    }

    /**
     * @param \Slab\Components\SystemInterface $system
     * @return null|\Slab\Components\ConfigurationManagerInterface
     */
    public function getConfigurationManager(\Slab\Components\SystemInterface $system)
    {
        return null;
    }

    /**
     * @param \Slab\Components\SystemInterface $system
     * @return null|\Slab\Components\Router\RouterInterface
     */
    public function getRouter(\Slab\Components\SystemInterface $system)
    {
        return null;
    }

    /**
     * @param \Slab\Components\SystemInterface $system
     * @return null|\Slab\Components\Database\DriverInterface
     */
    public function getDatabaseProvider(\Slab\Components\SystemInterface $system)
    {
        return null;
    }

    /**
     * @param \Slab\Components\SystemInterface $system
     * @return mixed|null
     */
    public function getSessionHandler(\Slab\Components\SystemInterface $system)
    {
        return null;
    }

    /**
     * @param \Slab\Components\SystemInterface $system
     * @return mixed|null
     */
    public function getCacheProvider(\Slab\Components\SystemInterface $system)
    {
        return null;
    }

}