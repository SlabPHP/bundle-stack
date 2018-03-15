<?php
/**
 * Tests for Standard Bundle
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Bundle;

class StandardTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test standard configuration object
     */
    public function testStandardConfiguration()
    {
        $bundle = new Mocks\Standard();
        $system = new \Slab\Tests\Components\Mocks\System();

        $this->assertEquals('Slab\Tests\Bundle\Mocks', $bundle->getNamespace());

        //This is a little goofy because Slab expects the configuration object to be in the base path, but the logic should be generally the same
        $slabDir = realpath(__DIR__);

        $this->assertEquals($slabDir . DIRECTORY_SEPARATOR . 'Mocks', $bundle->getSourceDirectory());
        $this->assertEquals($slabDir, $bundle->getPackageDirectory());
        $this->assertEquals($slabDir . DIRECTORY_SEPARATOR . 'Mocks' . DIRECTORY_SEPARATOR . 'views', $bundle->getViewDirectory());
        $this->assertEquals($slabDir . DIRECTORY_SEPARATOR . 'config', $bundle->getConfigDirectory());
        $this->assertEquals($slabDir . DIRECTORY_SEPARATOR . 'resources', $bundle->getResourceDirectory());

        $this->assertNull($bundle->getInputManager());
        $this->assertNull($bundle->getConfigurationManager($system));
        $this->assertNull($bundle->getCacheProvider($system));
        $this->assertNull($bundle->getLogger());
        $this->assertNull($bundle->getSessionHandler($system));
        $this->assertNull($bundle->getDatabaseProvider($system));
    }
}