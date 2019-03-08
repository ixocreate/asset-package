<?php
declare(strict_types=1);

namespace IxocreateTest\Asset;

use Ixocreate\Application\ApplicationConfig;
use Ixocreate\Application\ApplicationConfigurator;
use Ixocreate\Asset\Version;
use PHPUnit\Framework\TestCase;

class VersionTest extends TestCase
{
    /**
     * @covers \Ixocreate\Asset\Version::__construct
     */
    public function testVersion()
    {
        $applicationConfigurator = new ApplicationConfigurator('/');
        $applicationConfig = new ApplicationConfig($applicationConfigurator);
        $version = new Version($applicationConfig);
        $this->assertInstanceOf(Version::class, $version);
    }

    /**
     * @covers \Ixocreate\Asset\Version::getVersion
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
     * @covers \Ixocreate\Asset\Version::generateVersion
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