<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Asset;

use Ixocreate\Asset\AssetConfig;
use Ixocreate\Asset\AssetConfigurator;
use Ixocreate\Asset\Strategy\Option\RandomOption;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ixocreate\Asset\AssetConfig
 */
class AssetConfigTest extends TestCase
{
    public function testAssetConfig()
    {
        $assetConfigurator = new AssetConfigurator();
        $assetConfigurator->setStrategy(new RandomOption());
        $assetConfigurator->setFormat('%2$s?v=%1$s');
        $assetConfigurator->setUrls(['/assets']);

        $assetConfig = new AssetConfig($assetConfigurator);
        $this->assertSame('%2$s?v=%1$s', $assetConfig->format());
        $this->assertSame(['/assets'], $assetConfig->urls());
        $this->assertInstanceOf(RandomOption::class, $assetConfig->strategy());

        $assetConfig = \unserialize(\serialize($assetConfig));
        $this->assertSame('%2$s?v=%1$s', $assetConfig->format());
        $this->assertSame(['/assets'], $assetConfig->urls());
        $this->assertInstanceOf(RandomOption::class, $assetConfig->strategy());
    }
}
