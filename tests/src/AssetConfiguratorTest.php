<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Asset;

use Ixocreate\Application\Service\ServiceRegistryInterface;
use Ixocreate\Asset\AssetConfig;
use Ixocreate\Asset\AssetConfigurator;
use Ixocreate\Asset\Strategy\Option\ComposerOption;
use Ixocreate\Asset\Strategy\Option\RandomOption;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ixocreate\Asset\AssetConfigurator
 */
class AssetConfiguratorTest extends TestCase
{
    public function testDefaults()
    {
        $assetConfigurator = new AssetConfigurator();
        $this->assertInstanceOf(RandomOption::class, $assetConfigurator->strategy());
        $this->assertSame('%1$s?v=%2$s', $assetConfigurator->format());
        $this->assertSame([], $assetConfigurator->urls());
    }

    public function testSetting()
    {
        $assetConfigurator = new AssetConfigurator();
        $assetConfigurator->setStrategy(new ComposerOption());
        $assetConfigurator->setFormat('%2$s?v=%1$s');
        $assetConfigurator->setUrls(['/assets']);
        $assetConfigurator->addUrl('/next_asset');

        $this->assertInstanceOf(ComposerOption::class, $assetConfigurator->strategy());
        $this->assertSame('%2$s?v=%1$s', $assetConfigurator->format());
        $this->assertSame(['/assets', '/next_asset'], $assetConfigurator->urls());
    }

    public function testRegisterService()
    {
        $collector = [];
        $serviceRegistry = $this->createMock(ServiceRegistryInterface::class);
        $serviceRegistry->method('add')->willReturnCallback(function ($name, $object) use (&$collector) {
            $collector[$name] = $object;
        });
        $configurator = new AssetConfigurator();
        $configurator->registerService($serviceRegistry);
        $this->assertArrayHasKey(AssetConfig::class, $collector);
        $this->assertInstanceOf(AssetConfig::class, $collector[AssetConfig::class]);
    }
}
