<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Asset;

use Ixocreate\Asset\AssetConfigurator;
use Ixocreate\Asset\BootstrapItem;
use PHPUnit\Framework\TestCase;

class BootstrapItemTest extends TestCase
{
    /**
     * @covers \Ixocreate\Asset\BootstrapItem
     */
    public function testBootstrapItem()
    {
        $bootstrapItem = new BootstrapItem();
        $this->assertSame('asset', $bootstrapItem->getVariableName());
        $this->assertSame('asset.php', $bootstrapItem->getFileName());
        $this->assertInstanceOf(AssetConfigurator::class, $bootstrapItem->getConfigurator());
    }
}
