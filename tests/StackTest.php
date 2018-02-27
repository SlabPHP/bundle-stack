<?php
/**
 * Stack Tests
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Bundle;

class StackTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Slab\Bundle\Stack
     */
    private $stack;

    /**
     * setup
     */
    public function setUp()
    {
        $bundleBase = new \Slab\Tests\Bundle\Mocks\BaseNamespace\Configuration('asdf');
        $bundleTwo = new \Slab\Tests\Bundle\Mocks\NamespaceTwo\Configuration('asdf2');
        $bundleThree = new \Slab\Tests\Bundle\Mocks\NamespaceCharlie\Configuration('asdf3');

        $this->stack = new \Slab\Bundle\Stack($bundleBase);

        $this->stack
            ->pushBundle($bundleTwo)
            ->pushBundle($bundleThree);
    }

    /**
     * Test stack creation and configuration
     */
    public function testClassResolution()
    {
        $this->assertEquals('\Slab\Tests\Bundle\Mocks\NamespaceTwo\Sample', $this->stack->findClassName('Sample'));
        $this->assertInstanceOf('\Slab\Tests\Bundle\Mocks\BaseNamespace\OnlyBase', $this->stack->findClass('OnlyBase'));
        $this->assertInstanceOf('\Slab\Tests\Bundle\Mocks\NamespaceCharlie\OnlyCharlie', $this->stack->findClass('OnlyCharlie'));
        $this->assertEquals('\Slab\Tests\Bundle\Mocks\NamespaceCharlie\Configuration', $this->stack->findClassName('Configuration'));
    }

    /**
      Test file resolution
     */
    public function testFileResolution()
    {
        $this->assertEquals('CONFIG CHARLIE!', file_get_contents($this->stack->findConfig('config.txt')));
        $this->assertEquals('#charlie { font-weight: normal; }', file_get_contents($this->stack->findResource('resource-charlie.css')));
        $this->assertEquals('#two { font-weight: bold; }', file_get_contents($this->stack->findResource('resource.css')));
        $this->assertEquals('VIEW!', file_get_contents($this->stack->findView('view-base.txt')));
    }

    /**
     * Test duplicate, throws an exception
     * @expectedException \Exception
     */
    public function testDuplicate()
    {
        $bundleThree = new \Slab\Tests\Bundle\Mocks\NamespaceCharlie\Configuration('asdf3');
        $this->stack->pushBundle($bundleThree);
    }
}