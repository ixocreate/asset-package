<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Asset;

use Ixocreate\Asset\Asset;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Asset\Packages;

class AssetTest extends TestCase
{
    /**
     * @covers \Ixocreate\Asset\Asset::__construct
     */
    public function testAsset()
    {
        $stub = $this->createMock(Packages::class);
        $asset = new Asset($stub);

        $this->assertTrue(true);
    }

    public function testGetUrl()
    {
        $stub = $this->createMock(Packages::class);

        $stub->method('getUrl')
            ->willReturnCallback(function ($path) {
                /**
                 * Do not prefix absolute urls
                 * This aligns with symfony asset package behaviour
                 */
                if (\mb_strpos($path, 'http') === 0) {
                    return $path;
                }
                return 'https://ixocreate.test/' . \ltrim($path, '/');
            });


        $asset = new Asset($stub);

        $this->assertSame('https://ixocreate.test/assets', $asset->getUrl('/assets'));

        /**
         * Asset::getUrl() does not automatically prefix paths
         * This should be done in the asset url configuration
         */
        $this->assertSame('https://ixocreate.test/assets', $asset->getUrl('assets'));

        $this->assertSame('https://ixocreate.test/assets', $asset->getUrl('https://ixocreate.test/assets'));
    }
}
