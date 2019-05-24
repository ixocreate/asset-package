<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Asset;

use Ixocreate\Asset\AssetBootstrapItem;
use Ixocreate\Asset\AssetConfigurator;
use PHPUnit\Framework\TestCase;

class AssetBootstrapItemTest extends TestCase
{
    /**
     * @covers \Ixocreate\Asset\AssetBootstrapItem
     */
    public function testBootstrapItem()
    {
        $bootstrapItem = new AssetBootstrapItem();
        $this->assertSame('asset', $bootstrapItem->getVariableName());
        $this->assertSame('asset.php', $bootstrapItem->getFileName());
        $this->assertInstanceOf(AssetConfigurator::class, $bootstrapItem->getConfigurator());
    }
}
