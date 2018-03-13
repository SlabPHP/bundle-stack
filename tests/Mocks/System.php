<?php
/**
 * Mock System
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Bundle\Mocks;

class System implements \Slab\Components\SystemInterface
{
    /**
     * @return mixed
     */
    public function config()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function session()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function log()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function input()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function router()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function db()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function cache()
    {
        return null;
    }

    /**
     * @return bool
     */
    public function routeRequest()
    {
        return null;
    }
}