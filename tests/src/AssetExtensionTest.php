<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Asset;

use Ixocreate\Asset\Asset;
use Ixocreate\Asset\Template\AssetExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Asset\Packages;

class AssetExtensionTest extends TestCase
{
    /**
     * @covers \Ixocreate\Asset\Template\AssetExtension
     */
    public function testAssetExtension()
    {
        $stub = $this->createMock(Packages::class);
        $stub->method('getUrl')
            ->willReturnCallback(function ($path) {
                return 'https://Ixocreate' . $path;
            });
        $asset = new Asset($stub);
        $assetExtension = new AssetExtension($asset);

        $this->assertInstanceOf(AssetExtension::class, $assetExtension);

        $this->assertSame('asset', $assetExtension->getName());
        $this->assertSame('https://Ixocreate/Asset/', $assetExtension('Asset/'));
    }
}
