<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace IxocreateTest\Asset;

use Ixocreate\Asset\ConfigProvider;
use PHPUnit\Framework\TestCase;

class ConfigProviderTest extends TestCase
{
    public function testinvoke()
    {
        $configProvider = new ConfigProvider();

        $this->assertSame(['asset' => ['url' => [], 'format' => '%1$s?v=%2$s', ], ], $configProvider());
        $this->assertSame('asset', $configProvider->configName());
        $this->assertStringMatchesFormatFile(__DIR__ . '/../../resources/asset.config.example.php', $configProvider->configContent());
    }
}
