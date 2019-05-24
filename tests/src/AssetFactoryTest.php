<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Asset;

use Ixocreate\Application\ApplicationConfig;
use Ixocreate\Application\ApplicationConfigurator;
use Ixocreate\Application\Uri\ApplicationUri;
use Ixocreate\Application\Uri\ApplicationUriConfigurator;
use Ixocreate\Asset\Asset;
use Ixocreate\Asset\AssetConfig;
use Ixocreate\Asset\AssetConfigurator;
use Ixocreate\Asset\Factory\AssetFactory;
use Ixocreate\ServiceManager\ServiceManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ixocreate\Asset\Factory\AssetFactory
 */
class AssetFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $configUrl = ['url' => 'assets'];

        $assetFactory = new AssetFactory();
        /** @var  Asset $asset */
        $asset = $assetFactory($this->serviceManagerMock($configUrl), 'Test');

        $this->assertInstanceOf(Asset::class, $asset);
    }

    public function testInvokeAbsolutUrl()
    {
        $configUrl = ['url' => 'https://try.ixocreate.com/'];

        $assetFactory = new AssetFactory();
        /** @var  Asset $asset */
        $asset = $assetFactory($this->serviceManagerMock($configUrl), 'Test');

        $url = \mb_substr($asset->getUrl('test'), 0, 30);
        $this->assertSame('https://try.ixocreate.com/test', $url);
    }

    public function testInvokeNoArray()
    {
        $configUrl = ['url' => 'assets'];

        $assetFactory = new AssetFactory();
        /** @var  Asset $asset */
        $asset = $assetFactory($this->serviceManagerMock($configUrl), 'Test');

        $this->assertInstanceOf(Asset::class, $asset);
    }

    public function testConfigEmpty()
    {
        $configUrl = [];

        $assetFactory = new AssetFactory();

        $this->expectException(\InvalidArgumentException::class);
        $assetFactory($this->serviceManagerMock($configUrl), 'Test');
    }

    public function testConfigFormatChange()
    {
        $configUrl = ['url' => ['assets'], 'format' => '%2$s?v=%1$s'];

        $assetFactory = new AssetFactory();
        /** @var  Asset $asset */
        $asset = $assetFactory($this->serviceManagerMock($configUrl), 'Test');

        $this->assertStringEndsWith('?v=test', $asset->getUrl('test'));
    }

    public function testConfigMoreUrl()
    {
        $configUrl = ['url' => ['assets', 'test']];

        $assetFactory = new AssetFactory();
        /** @var  Asset $asset */
        $asset = $assetFactory($this->serviceManagerMock($configUrl), 'Ixocreate\Asset\Asset');

        $this->assertInstanceOf(Asset::class, $asset);
    }

    private function serviceManagerMock(array $configUrl, $developmentMode = true)
    {
        $serviceManagerMock = $this->createMock(ServiceManagerInterface::class);
        $serviceManagerMock->method('get')
            ->willReturnCallback(function ($request) use ($configUrl, $developmentMode) {
                switch ($request) {
                    case ApplicationConfig::class:
                        $applicationConfigurator = new ApplicationConfigurator('/');
                        $applicationConfigurator->setDevelopment($developmentMode);
                        return new ApplicationConfig($applicationConfigurator);
                    case ApplicationUri::class:
                        $applicationUriConfigurator = new ApplicationUriConfigurator();
                        $applicationUriConfigurator->setMainUri('https://example.com');
                        return new ApplicationUri($applicationUriConfigurator);
                    case AssetConfig::class:
                        $assetConfigurator = new AssetConfigurator();
                        if (isset($configUrl['url'])) {
                            if (\is_string($configUrl['url'])) {
                                $assetConfigurator->addUrl($configUrl['url']);
                            } elseif (\is_array($configUrl['url'])) {
                                $assetConfigurator->setUrls($configUrl['url']);
                            }
                        }

                        if (isset($configUrl['format'])) {
                            $assetConfigurator->setFormat($configUrl['format']);
                        }

                        return new AssetConfig($assetConfigurator);
                }
                return null;
            });
        return $serviceManagerMock;
    }
}
