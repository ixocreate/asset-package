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
use Ixocreate\Asset\Package\Version;
use PHPUnit\Framework\TestCase;

class VersionTest extends TestCase
{
    /**
     * @covers \Ixocreate\Asset\Package\Version::__construct
     */
    public function testVersion()
    {
        $applicationConfigurator = new ApplicationConfigurator('/');
        $applicationConfig = new ApplicationConfig($applicationConfigurator);
        $version = new Version($applicationConfig);
        $this->assertInstanceOf(Version::class, $version);
    }

    /**
     * @covers \Ixocreate\Asset\Package\Version::getVersion
     */
    public function testGetVersion()
    {
        $applicationConfigurator = new ApplicationConfigurator('/');
        $applicationConfig = new ApplicationConfig($applicationConfigurator);
        $version = new Version($applicationConfig);
        $versionId = $version->getVersion();
        $this->assertStringMatchesFormat('%x', $versionId);
    }

    /**
     * @covers \Ixocreate\Asset\Package\Version::generateVersion
     */
    public function testGenerateVersion()
    {
        $applicationConfiguratorDevTrue = new ApplicationConfigurator('/');
        $applicationConfig = new ApplicationConfig($applicationConfiguratorDevTrue);
        $version = new Version($applicationConfig);
        $versionId = $version->getVersion();
        $this->assertStringMatchesFormat('%x', $versionId);


        $applicationConfiguratorDevFalse = new ApplicationConfigurator('/');
        $applicationConfiguratorDevFalse->setDevelopment(false);
        $applicationConfig = new ApplicationConfig($applicationConfiguratorDevFalse);
        $version = new Version($applicationConfig);
        $versionId = $version->getVersion();
        $this->assertStringMatchesFormat('%x', $versionId);
    }
}
