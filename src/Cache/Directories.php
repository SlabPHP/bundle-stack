<?php
/**
 * Bundle Manager Directory Cache
 *
 * @package Slab
 * @subpackage Bundle
 * @author Eric
 */
namespace Slab\Bundle\Cache;

class Directories
{
    /**
     * @var array
     */
    public $viewDirectories = [];

    /**
     * @var array
     */
    public $configDirectories = [];

    /**
     * @var array
     */
    public $resourceDirectories = [];

    /**
     * @var array
     */
    private $bundleReference;

    /**
     * @var array
     */
    private $orderReference;

    /**
     * Directories constructor.
     * @param array $bundles
     * @param array $order
     */
    public function __construct(&$bundles, &$order)
    {
        $this->bundleReference =& $bundles;
        $this->orderReference =& $order;
    }

    /**
     * Build directory cache, so we only do it once
     */
    public function buildCache()
    {
        if (!empty($this->viewDirectories) || !empty($this->configDirectories) || !empty($this->resourceDirectories)) {
            return;
        }

        foreach ($this->orderReference as $namespace)
        {
            /**
             * @var \Slab\Components\BundleInterface $bundle
             */
            $bundle =& $this->bundleReference[$namespace];

            $this->viewDirectories[] = $bundle->getViewDirectory();
            $this->configDirectories[] = $bundle->getConfigDirectory();
            $this->resourceDirectories[] = $bundle->getResourceDirectory();
        }
    }
}