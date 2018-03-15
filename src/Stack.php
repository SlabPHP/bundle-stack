<?php
/**
 * SlabPHP Bundle Stack Manager
 *
 * @package Slab
 * @subpackage Bundle
 * @author Eric
 */
namespace Slab\Bundle;

class Stack implements \Slab\Components\BundleStackInterface
{
    /**
     * @var \Slab\Components\BundleInterface[]
     */
    private $bundles = [];

    /**
     * @var string[]
     */
    private $searchOrder = [];

    /**
     * @var Cache\Local
     */
    private $lookupCache;

    /**
     * @var Cache\Directories
     */
    private $directories;

    /**
     * Stack constructor.
     * @param \Slab\Components\BundleInterface $mainBundle
     * @throws \Exception
     */
    public function __construct(\Slab\Components\BundleInterface $mainBundle)
    {
        $this->pushBundle($mainBundle);
    }

    /**
     * @param \Slab\Components\BundleInterface $bundle
     * @return $this
     * @throws \Exception
     */
    public function pushBundle(\Slab\Components\BundleInterface $bundle)
    {
        $namespace = $bundle->getNamespace();

        if (!empty($this->bundles[$namespace]))
        {
            throw new \Exception("The bundle with the namespace " . $namespace . " is already in the stack.");
        }

        $this->bundles[$namespace] = $bundle;
        array_unshift($this->searchOrder, $namespace);

        $this->directories = new Cache\Directories($this->bundles, $this->searchOrder);

        return $this;
    }

    /**
     * @param bool $latestFirst
     * @return \Slab\Components\BundleInterface[]
     */
    public function getBundles($latestFirst = false)
    {
        if ($latestFirst)
        {
            return array_reverse($this->bundles);
        }

        return $this->bundles;
    }

    /**
     * Find class name
     *
     * @param $className
     * @return null|string
     */
    public function findClassName($className)
    {
        if (!empty($this->lookupCache->classes[$className])) {
            return $this->lookupCache->classes[$className];
        }

        if (class_exists($className)) return $className;
        $startsWithSlash = ($className[0] == '\\');

        foreach ($this->searchOrder as $namespace)
        {
            $testClass = '\\' . $namespace;
            if (!$startsWithSlash) {
                $testClass .= '\\';
            }

            $testClass .= $className;

            if (class_exists($testClass)) {
                $this->lookupCache->classes[$className] = $testClass;
                return $testClass;
            }
        }

        return null;
    }

    /**
     * @param $className
     * @return null|object
     */
    public function findClass($className)
    {
        $className = $this->findClassName($className);

        if (empty($className)) return null;

        $object = new $className();

        return $object;
    }

    /**
     * @param $name
     * @param $directories
     * @param $cacheArray
     * @return null|string
     */
    private function locateSpecificFile($name, $directories, &$cacheArray)
    {
        if (!empty($cacheArray[$name])) {
            return $cacheArray[$name];
        }

        foreach ($directories as $directory)
        {
            $filename = $directory . DIRECTORY_SEPARATOR . $name;

            if (is_file($filename) && is_readable($filename))
            {
                $cacheArray[$name] = $filename;
                return $filename;
            }
        }

        return null;
    }

    /**
     * @param $viewName
     * @return null|string
     */
    public function findView($viewName)
    {
        $this->directories->buildCache();

        return $this->locateSpecificFile(
            $viewName,
            $this->directories->viewDirectories,
            $this->lookupCache->views
        );
    }

    /**
     * @param $configFileName
     * @return null|string
     */
    public function findConfig($configFileName)
    {
        $this->directories->buildCache();

        return $this->locateSpecificFile(
            $configFileName,
            $this->directories->configDirectories,
            $this->lookupCache->configs
        );
    }

    /**
     * @param $resourceFileName
     * @return null|string
     */
    public function findResource($resourceFileName)
    {
        $this->directories->buildCache();

        return $this->locateSpecificFile(
            $resourceFileName,
            $this->directories->resourceDirectories,
            $this->lookupCache->resources
        );
    }

    /**
     * @return array
     */
    public function getResourceDirectories()
    {
        $this->directories->buildCache();

        return $this->directories->resourceDirectories;
    }

    /**
     * @return array
     */
    public function getConfigDirectories()
    {
        $this->directories->buildCache();

        return $this->directories->configDirectories;
    }

    /**
     * @return array
     */
    public function getViewDirectories()
    {
        $this->directories->buildCache();

        return $this->directories->viewDirectories;
    }
}