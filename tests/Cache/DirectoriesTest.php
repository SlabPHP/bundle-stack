<?php
/**
 * Some quick tests around directories caching
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Bundle\Cache;

class DirectoriesTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test the directories caching object
     */
    public function testDirectoriesCache()
    {
        $bundles = [
            '\Slab\Tests\Bundle\Mocks\BaseNamespace' => new \Slab\Tests\Bundle\Mocks\BaseNamespace\Configuration('asdf'),
            '\Slab\Tests\Bundle\Mocks\NamespaceTwo' => new \Slab\Tests\Bundle\Mocks\NamespaceTwo\Configuration('asdf2'),
            '\Slab\Tests\Bundle\Mocks\NamespaceCharlie' => new \Slab\Tests\Bundle\Mocks\NamespaceCharlie\Configuration('asdf3')
        ];

        $order = [
            '\Slab\Tests\Bundle\Mocks\NamespaceCharlie',
            '\Slab\Tests\Bundle\Mocks\NamespaceTwo',
            '\Slab\Tests\Bundle\Mocks\BaseNamespace'
        ];

        $directories = new \Slab\Bundle\Cache\Directories($bundles, $order);

        $this->assertEmpty($directories->resourceDirectories);
        $this->assertEmpty($directories->configDirectories);
        $this->assertEmpty($directories->viewDirectories);

        $directories->buildCache();

        $this->assertCount(3, $directories->resourceDirectories);
        $this->assertCount(3, $directories->configDirectories);
        $this->assertCount(3, $directories->viewDirectories);

        //This shouldn't happen but just to test the references
        unset($bundles['\Slab\Tests\Bundle\Mocks\NamespaceCharlie']);
        unset($order[0]);

        $directories->buildCache();
        //These should still  be three which denotes that buildCache didn't do anything because the dirs already have content

        $this->assertCount(3, $directories->resourceDirectories);
        $this->assertCount(3, $directories->configDirectories);
        $this->assertCount(3, $directories->viewDirectories);

        unset($directories->resourceDirectories);
        unset($directories->configDirectories);
        unset($directories->viewDirectories);

        $directories->buildCache();
        //Now buildCache should do something and with the updated references it should be 2
        $this->assertCount(2, $directories->resourceDirectories);
        $this->assertCount(2, $directories->configDirectories);
        $this->assertCount(2, $directories->viewDirectories);
    }
}