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
use Ixocreate\Application\Config\Config;
use Ixocreate\Application\Uri\ApplicationUri;
use Ixocreate\Application\Uri\ApplicationUriConfigurator;
use Ixocreate\Asset\Asset;
use Ixocreate\Asset\Factory\AssetFactory;
use Ixocreate\ServiceManager\ServiceManagerInterface;
use PHPUnit\Framework\TestCase;

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

    public function testFilesVersion()
    {
        $configUrl = ['asset' => ['url' => ['assets'], 'format' => '%1$s?v=%2$s', 'versionFilename' => 'tests/misc/valid_versionfile.php']];

        $assetFactory = new AssetFactory();
        /** @var  Asset $asset */
        $asset = $assetFactory($this->serviceManagerMock($configUrl, false), 'Test');
        $this->assertStringEndsWith('?v=' . require 'tests/misc/valid_versionfile.php', $asset->getUrl('test'));
    }

    public function testConfigMoreUrl()
    {
        $configUrl = ['asset' => ['url' => ['assets', 'test']]];

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
                    case Config::class:
                        return new Config($configUrl);
                }
                return null;
            });
        return $serviceManagerMock;
    }
}
