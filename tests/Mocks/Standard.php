<?php
/**
 * Mock Standard Configuration Extension
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Bundle\Mocks;

class Standard extends \Slab\Bundle\Standard
{
    /**
     * @return mixed|string
     */
    protected function getCurrentWorkingDirectory()
    {
        return __DIR__;
    }
}