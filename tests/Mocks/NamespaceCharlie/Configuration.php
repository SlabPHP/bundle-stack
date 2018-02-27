<?php
/**
 * Mock Class
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Bundle\Mocks\NamespaceCharlie;

class Configuration implements \Slab\Components\BundleInterface
{
    /**
     * BundleInterface constructor.
     */
    public function __construct($namespace)
    {

    }

    /**
     * @return string
     */
    public function getSourceDirectory()
    {
        return __DIR__;
    }

    /**
     * @return string
     */
    public function getPackageDirectory()
    {
        return __DIR__;
    }

    /**
     * @return string
     */
    public function getViewDirectory()
    {
        return __DIR__ . '/views';
    }

    /**
     * @return string
     */
    public function getConfigDirectory()
    {
        return __DIR__ . '/configs';
    }

    /**
     * @return string
     */
    public function getResourceDirectory()
    {
        return __DIR__ . '/resources';
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return dirname(get_called_class());
    }
}