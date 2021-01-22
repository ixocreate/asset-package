<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Asset;

use Ixocreate\Asset\AssetBootstrapItem;
use Ixocreate\Asset\Package;
use PHPUnit\Framework\TestCase;

class PackageTest extends TestCase
{
    /**
     * @covers \Ixocreate\Asset\Package
     */
    public function testPackage()
    {
        $package = new Package();

        $this->assertSame([AssetBootstrapItem::class], $package->getBootstrapItems());
        $this->assertDirectoryExists($package->getBootstrapDirectory());
        $this->assertEmpty($package->getDependencies());
    }
}
