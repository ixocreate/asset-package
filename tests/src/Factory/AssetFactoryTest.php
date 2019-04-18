<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Asset;

use Ixocreate\Application\ApplicationConfig;
use Ixocreate\Application\ApplicationConfigurator;
use Ixocreate\Asset\Asset;
use Ixocreate\Asset\Factory\AssetFactory;
use Ixocreate\Application\Config\Config;
use Ixocreate\ServiceManager\ServiceManagerInterface;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Uri;

class AssetFactoryTest extends TestCase
{
    /**
     * @covers \Ixocreate\Asset\Factory\AssetFactory::__invoke
     */
    public function testInvoke()
    {
        $configUrl = ['asset' => ['url' => 'assets']];

        $assetFactory = new AssetFactory();
        /** @var  Asset $asset */
        $asset = $assetFactory($this->serviceManagerMock($configUrl), 'Test');

        $this->assertInstanceOf(Asset::class, $asset);
    }

    public function testInvokeAbsolutUrl()
    {
        $configUrl = ['asset' => ['url' => 'https://spielwiese.ixocreate.com/']];

        $assetFactory = new AssetFactory();
        /** @var  Asset $asset */
        $asset = $assetFactory($this->serviceManagerMock($configUrl), 'Test');

        $url = \mb_substr($asset->getUrl('test'), 0, 37);
        $this->assertSame('https://spielwiese.ixocreate.com/test', $url);
    }

    public function testInvokeNoArray()
    {
        $configUrl = ['asset' => ['url' => 'assets']];

        $assetFactory = new AssetFactory();
        /** @var  Asset $asset */
        $asset = $assetFactory($this->serviceManagerMock($configUrl), 'Test');

        $this->assertInstanceOf(Asset::class, $asset);
    }

    public function testConfigEmpty()
    {
        $configUrl = ['asset' => ['url' => '']];

        $assetFactory = new AssetFactory();

        $this->expectException(\InvalidArgumentException::class);
        $assetFactory($this->serviceManagerMock($configUrl), 'Test');
    }

    public function testConfigFormatChange()
    {
        $configUrl = ['asset' => ['url' => ['assets'], 'format' => '%2$s?v=%1$s']];

        $assetFactory = new AssetFactory();
        /** @var  Asset $asset */
        $asset = $assetFactory($this->serviceManagerMock($configUrl), 'Test');

        $this->assertStringEndsWith('?v=test', $asset->getUrl('test'));
    }

    public function testConfigMoreUrl()
    {
        $configUrl = ['asset' => ['url' => ['assets', 'test']]];

        $assetFactory = new AssetFactory();
        /** @var  Asset $asset */
        $asset = $assetFactory($this->serviceManagerMock($configUrl), 'Ixocreate\Asset\Asset');

        $this->assertInstanceOf(Asset::class, $asset);
    }

    private function serviceManagerMock(array $configUrl)
    {
        $serviceManagerMock = $this->createMock(ServiceManagerInterface::class);
        $serviceManagerMock->method('get')
            ->willReturnCallback(function ($request) use ($configUrl) {
                switch ($request) {
                    case ApplicationConfig::class:
                        return new ApplicationConfig(new ApplicationConfigurator('/'));
                    case Uri::class:
                        return new Uri(new Uri('https://spielwiese.ixocreate.test/'), []);
                    case Config::class:
                        return  new Config($configUrl);
                }
            });
        return $serviceManagerMock;
    }
}
